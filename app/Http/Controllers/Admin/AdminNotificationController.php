<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\VendorWithdrawal;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(20);

        return view(
            'admin.notifications.index',
            compact('notifications')
        );
    }

    public function show(DatabaseNotification $notification)
    {
        abort_unless(
            $notification->notifiable_id == auth()->id(),
            403
        );

        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        return redirect(
            $notification->data['url']
            ?? route('dashboard')
        );
    }

    public function markAllRead()
    {
        auth()->user()
            ->unreadNotifications
            ->markAsRead();

        return back();
    }
}