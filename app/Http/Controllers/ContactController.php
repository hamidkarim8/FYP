<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ContactNotification;

class ContactController extends Controller
{
    public function sendEmail(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'comments' => $request->comments,
        ];

        Notification::route('mail', 'hamidkarim2002@gmail.com')
            ->notify(new ContactNotification($data));

        return redirect()->back()->with('message', 'Your message has been sent!');
    }
}
