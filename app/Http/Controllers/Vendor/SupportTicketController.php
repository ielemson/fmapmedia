<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use App\Models\User;
use App\Notifications\AdminNotification;
use App\Notifications\SupportTicketReplyNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SupportTicketController extends Controller
{
    public function index(Request $request): View
    {
        $vendor = $this->vendor($request);

        $tickets = SupportTicket::query()
            ->where('vendor_id', $vendor->id)
            ->when(
                $request->filled('status'),
                fn($query) => $query->where(
                    'status',
                    $request->status
                )
            )
            ->when(
                $request->filled('priority'),
                fn($query) => $query->where(
                    'priority',
                    $request->priority
                )
            )
            ->when(
                $request->filled('search'),
                function ($query) use ($request) {
                    $search = $request->search;

                    $query->where(function ($subQuery) use ($search) {
                        $subQuery
                            ->where('ticket_number', 'like', "%{$search}%")
                            ->orWhere('subject', 'like', "%{$search}%");
                    });
                }
            )
            ->withCount('publicReplies')
            ->latest('last_reply_at')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $statistics = [
            'total' => SupportTicket::where(
                'vendor_id',
                $vendor->id
            )->count(),

            'open' => SupportTicket::where(
                'vendor_id',
                $vendor->id
            )->where('status', 'open')->count(),

            'in_progress' => SupportTicket::where(
                'vendor_id',
                $vendor->id
            )->where('status', 'in_progress')->count(),

            'resolved' => SupportTicket::where(
                'vendor_id',
                $vendor->id
            )->where('status', 'resolved')->count(),
        ];

        return view(
            'vendor.support.index',
            compact('tickets', 'statistics')
        );
    }

    public function create(Request $request): View
    {
        $this->vendor($request);

        return view('vendor.support.create');
    }

   public function store(Request $request): RedirectResponse
{
    $vendor = $this->vendor($request);

    $validated = $request->validate([
        'subject' => [
            'required',
            'string',
            'max:255',
        ],

        'category' => [
            'required',
            'in:account,commission,withdrawal,payment,referral,technical,magazine,other',
        ],

        'priority' => [
            'required',
            'in:low,medium,high,urgent',
        ],

        'message' => [
            'required',
            'string',
            'min:10',
        ],

        'attachment' => [
            'nullable',
            'file',
            'mimes:jpg,jpeg,png,webp,pdf,doc,docx',
            'max:5120',
        ],
    ]);

    $ticket = DB::transaction(function () use (
        $request,
        $validated,
        $vendor
    ) {
        $attachment = null;

        if ($request->hasFile('attachment')) {
            $attachment = $request
                ->file('attachment')
                ->store('support-tickets', 'public');
        }

        return SupportTicket::create([
            'vendor_id' => $vendor->id,
            'user_id' => $request->user()->id,
            'ticket_number' => $this->generateTicketNumber(),
            'subject' => $validated['subject'],
            'category' => $validated['category'],
            'priority' => $validated['priority'],
            'status' => 'open',
            'message' => $validated['message'],
            'attachment' => $attachment,
            'last_reply_at' => now(),
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | Notify Administrators
    |--------------------------------------------------------------------------
    */

    $admins = User::role('Admin')->get();

    foreach ($admins as $admin) {
        $admin->notify(
            new AdminNotification(
                title: 'New Vendor Support Ticket',

                message: "{$vendor->business_name} raised a " .
                    ucfirst($ticket->priority) .
                    " priority support ticket: {$ticket->subject}",

                url: route(
                    'admin.support.show',
                    $ticket
                ),

                type: match ($ticket->priority) {
                    'urgent' => 'danger',
                    'high' => 'warning',
                    'medium' => 'info',
                    'low' => 'primary',
                    default => 'info',
                }
            )
        );
    }

    return redirect()
        ->route(
            'vendor.support.show',
            $ticket
        )
        ->with(
            'success',
            'Your support ticket has been submitted successfully.'
        );
}

    public function show(
        Request $request,
        SupportTicket $supportTicket
    ): View {
        $vendor = $this->vendor($request);

        abort_unless(
            $supportTicket->vendor_id === $vendor->id,
            403
        );

        $supportTicket->load([
            'user',
            'publicReplies.user',
            'assignedAdmin',
        ]);

        return view(
            'vendor.support.show',
            compact('supportTicket')
        );
    }

public function reply(
    Request $request,
    SupportTicket $supportTicket
): RedirectResponse {
    $vendor = $this->vendor($request);

    abort_unless(
        $supportTicket->vendor_id === $vendor->id,
        403
    );

    if ($supportTicket->status === 'closed') {
        return back()->with(
            'error',
            'This ticket is closed. Reopen it before replying.'
        );
    }

    $validated = $request->validate([
        'message' => [
            'required',
            'string',
            'min:2',
        ],

        'attachment' => [
            'nullable',
            'file',
            'mimes:jpg,jpeg,png,webp,pdf,doc,docx',
            'max:5120',
        ],
    ]);

    $reply = DB::transaction(function () use (
        $request,
        $validated,
        $supportTicket
    ) {
        $attachment = null;

        if ($request->hasFile('attachment')) {
            $attachment = $request
                ->file('attachment')
                ->store('support-ticket-replies', 'public');
        }

        $reply = SupportTicketReply::create([
            'support_ticket_id' => $supportTicket->id,
            'user_id' => $request->user()->id,
            'message' => $validated['message'],
            'attachment' => $attachment,
            'is_admin_reply' => false,
            'is_internal_note' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Reopen Ticket for Admin Attention
        |--------------------------------------------------------------------------
        */

        $supportTicket->update([
            'status' => 'open',
            'resolved_at' => null,
            'closed_at' => null,
            'last_reply_at' => now(),
        ]);

        return $reply;
    });

    /*
    |--------------------------------------------------------------------------
    | Notify Administrators
    |--------------------------------------------------------------------------
    */

    $admins = User::role('Admin')->get();

    $businessName = $vendor->business_name
        ?: $request->user()->name
        ?: 'A vendor';

    foreach ($admins as $admin) {
        $admin->notify(
            new AdminNotification(
                title: 'Vendor Replied to Support Ticket',

                message: "{$businessName} replied to ticket "
                    . "{$supportTicket->ticket_number}: "
                    . "{$supportTicket->subject}",

                url: route(
                    'admin.support.show',
                    $supportTicket
                ),

                type: match ($supportTicket->priority) {
                    'urgent' => 'danger',
                    'high' => 'warning',
                    'medium' => 'info',
                    'low' => 'primary',
                    default => 'info',
                }
            )
        );
    }

    return back()->with(
        'success',
        'Your reply has been added successfully. The support team has been notified.'
    );
}

    public function close(
        Request $request,
        SupportTicket $supportTicket
    ): RedirectResponse {
        $vendor = $this->vendor($request);

        abort_unless(
            $supportTicket->vendor_id === $vendor->id,
            403
        );

        $supportTicket->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return back()->with(
            'success',
            'The support ticket has been closed.'
        );
    }

    public function reopen(
        Request $request,
        SupportTicket $supportTicket
    ): RedirectResponse {
        $vendor = $this->vendor($request);

        abort_unless(
            $supportTicket->vendor_id === $vendor->id,
            403
        );

        $supportTicket->update([
            'status' => 'open',
            'resolved_at' => null,
            'closed_at' => null,
            'last_reply_at' => now(),
        ]);

        return back()->with(
            'success',
            'The support ticket has been reopened.'
        );
    }

    private function vendor(Request $request)
    {
        $vendor = $request->user()->vendor;

        abort_unless($vendor, 403, 'Vendor account not found.');

        return $vendor;
    }

    private function generateTicketNumber(): string
    {
        do {
            $ticketNumber = 'SUP-' .
                now()->format('Ymd') .
                '-' .
                strtoupper(Str::random(6));
        } while (
            SupportTicket::where(
                'ticket_number',
                $ticketNumber
            )->exists()
        );

        return $ticketNumber;
    }
}
