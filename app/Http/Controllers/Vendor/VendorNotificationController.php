<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotification;

class VendorNotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(20);

        return view('vendor.notifications.index', compact('notifications'));
    }

    public function show(DatabaseNotification $notification)
    {
        abort_unless($notification->notifiable_id == auth()->id(), 403);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return redirect(
            $notification->data['url'] ?? route('dashboard')
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