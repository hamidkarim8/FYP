<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function fetchNotifications()
    {
        $user = Auth::user();

        if ($user) {
            $unreadNotifications = DB::table('notifications')
                ->where('notifiable_id', $user->id)
                ->where('notifiable_type', 'App\Models\User')
                ->whereNull('read_at')
                ->orderBy('created_at', 'desc')
                ->get();

            $readNotifications = DB::table('notifications')
                ->where('notifiable_id', $user->id)
                ->where('notifiable_type', 'App\Models\User')
                ->whereNotNull('read_at')
                ->orderBy('read_at', 'desc')
                ->get();

            $notifications = $unreadNotifications->concat($readNotifications);

            $notifications->transform(function ($notification) {
                $notification->data = json_decode($notification->data, true);
                return $notification;
            });

            return response()->json(['notifications' => $notifications], 200);
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->markAsRead();
    
        return response()->json(['message' => 'Notification marked as read']);
    }
    
    public function markAsUnread($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['read_at' => null]);
    
        return response()->json(['message' => 'Notification marked as unread']);
    }
}
