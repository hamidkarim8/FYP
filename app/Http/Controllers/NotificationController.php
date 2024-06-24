<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function fetchNotifications()
    {
        $user = Auth::user();

        if ($user) {
            $notifications = DB::table('notifications')
                ->where('notifiable_id', $user->id)
                ->where('notifiable_type', 'App\Models\User')
                // ->limit(10)
                ->get();
            $notifications->transform(function ($notification) {
                $notification->data = json_decode($notification->data, true);
                return $notification;
            });
            //    dd($notifications);
            return response()->json(['notifications' => $notifications], 200);
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }
}
