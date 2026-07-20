<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use App\Models\User;
use App\Notifications\SupportTicketReplyNotification;
use App\Notifications\SupportTicketStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SupportTicketController extends Controller
{
    public function index(Request $request): View
    {
        $tickets = SupportTicket::query()
            ->with([
                'vendor',
                'user',
                'assignedAdmin',
            ])
            ->withCount('publicReplies')

            ->when(
                $request->filled('search'),
                function ($query) use ($request) {
                    $search = $request->search;

                    $query->where(function ($subQuery) use ($search) {

                        $subQuery
                            ->where(
                                'ticket_number',
                                'like',
                                "%{$search}%"
                            )

                            ->orWhere(
                                'subject',
                                'like',
                                "%{$search}%"
                            )

                            ->orWhereHas(
                                'vendor',
                                function ($vendorQuery) use ($search) {
                                    $vendorQuery->where(
                                        'business_name',
                                        'like',
                                        "%{$search}%"
                                    );
                                }
                            )

                            ->orWhereHas(
                                'user',
                                function ($userQuery) use ($search) {
                                    $userQuery
                                        ->where(
                                            'name',
                                            'like',
                                            "%{$search}%"
                                        )

                                        ->orWhere(
                                            'email',
                                            'like',
                                            "%{$search}%"
                                        );
                                }
                            );
                    });
                }
            )

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
                $request->filled('category'),
                fn($query) => $query->where(
                    'category',
                    $request->category
                )
            )

            ->latest('last_reply_at')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $statistics = [

            'total' => SupportTicket::count(),

            'open' => SupportTicket::where(
                'status',
                'open'
            )->count(),

            'in_progress' => SupportTicket::where(
                'status',
                'in_progress'
            )->count(),

            'urgent' => SupportTicket::where(
                'priority',
                'urgent'
            )
                ->whereNotIn(
                    'status',
                    [
                        'resolved',
                        'closed',
                    ]
                )
                ->count(),
        ];

        return view(
            'admin.support.index',
            compact(
                'tickets',
                'statistics'
            )
        );
    }

    public function show(
        SupportTicket $supportTicket
    ): View {

        $supportTicket->load([
            'vendor',
            'user',
            'assignedAdmin',
            'replies.user',
        ]);

        $administrators = User::role('Admin')
            ->orderBy('first_name')
            ->get();

        return view(
            'admin.support.show',
            compact(
                'supportTicket',
                'administrators'
            )
        );
    }

    public function reply(
        Request $request,
        SupportTicket $supportTicket
    ): RedirectResponse {

        if ($supportTicket->status === 'closed') {

            return back()->with(
                'error',
                'This ticket has already been closed.'
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

            'is_internal_note' => [
                'required',
                'boolean',
            ],
        ]);

        DB::transaction(function () use (
            $request,
            $supportTicket,
            $validated
        ) {

            $attachment = null;

            if ($request->hasFile('attachment')) {

                $attachment = $request
                    ->file('attachment')
                    ->store(
                        'support-ticket-replies',
                        'public'
                    );
            }

            SupportTicketReply::create([

                'support_ticket_id' => $supportTicket->id,

                'user_id' => auth()->id(),

                'message' => $validated['message'],

                'attachment' => $attachment,

                'is_admin_reply' => true,

                'is_internal_note' => $request
                    ->boolean(
                        'is_internal_note'
                    ),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Internal notes do not change status
            |--------------------------------------------------------------------------
            */

            if (!$request->boolean('is_internal_note')) {

                $supportTicket->update([

                    'status' => 'waiting_vendor',

                    'last_reply_at' => now(),
                ]);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Notify Vendor
        |--------------------------------------------------------------------------
        */

        if (!$request->boolean('is_internal_note')) {

            $supportTicket->user?->notify(
                new SupportTicketReplyNotification(
                    $supportTicket
                )
            );
        }

        return back()->with(
            'success',
            $request->boolean(
                'is_internal_note'
            )
                ? 'Internal note added successfully.'
                : 'Reply sent successfully.'
        );
    }

    public function updateStatus(
        Request $request,
        SupportTicket $supportTicket
    ): RedirectResponse {

        $validated = $request->validate([

            'status' => [
                'required',
                'in:open,in_progress,waiting_vendor,resolved,closed',
            ],
        ]);

        $data = [
            'status' => $validated['status'],
        ];

        if (
            $validated['status'] === 'resolved'
        ) {
            $data['resolved_at'] = now();
        }

        if (
            $validated['status'] === 'closed'
        ) {
            $data['closed_at'] = now();
        }

        if (
            in_array(
                $validated['status'],
                ['open', 'in_progress']
            )
        ) {
            $data['resolved_at'] = null;
            $data['closed_at'] = null;
        }

        $supportTicket->update($data);

        /*
        |--------------------------------------------------------------------------
        | Notify Vendor
        |--------------------------------------------------------------------------
        */

        $supportTicket->user?->notify(
            new SupportTicketStatusNotification(
                $supportTicket
            )
        );

        return back()->with(
            'success',
            'Ticket status updated successfully.'
        );
    }

    public function updatePriority(
        Request $request,
        SupportTicket $supportTicket
    ): RedirectResponse {

        $validated = $request->validate([

            'priority' => [
                'required',
                'in:low,medium,high,urgent',
            ],
        ]);

        $supportTicket->update([

            'priority' => $validated['priority'],
        ]);

        return back()->with(
            'success',
            'Ticket priority updated successfully.'
        );
    }

    public function assign(
        Request $request,
        SupportTicket $supportTicket
    ): RedirectResponse {

        $validated = $request->validate([

            'assigned_to' => [
                'nullable',
                'exists:users,id',
            ],
        ]);

        if (!empty($validated['assigned_to'])) {

            $user = User::find(
                $validated['assigned_to']
            );

            if (
                !$user->hasRole('Admin')
            ) {

                return back()->with(
                    'error',
                    'Selected user is not an administrator.'
                );
            }
        }

        $supportTicket->update([

            'assigned_to' => $validated['assigned_to'],
        ]);

        return back()->with(
            'success',
            $validated['assigned_to']
                ? 'Ticket assigned successfully.'
                : 'Ticket unassigned successfully.'
        );
    }
}