<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(20);

        return view(
            'notifications.index',
            compact('notifications')
        );
    }

    public function show(DatabaseNotification $notification)
    {
        abort_unless(
            $notification->notifiable_id === auth()->id(),
            403
        );

        if (is_null($notification->read_at)) {
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