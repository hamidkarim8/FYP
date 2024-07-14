<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ContactNotification;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    public function sendEmail(Request $request)
    {
        try{
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'comments' => $request->comments,
            ];
    
            Notification::route('mail', 'hamidkarim2002@gmail.com')
                ->notify(new ContactNotification($data));
    
            return redirect()->back()->with('success', 'Your message has been sent!');
        } catch(ValidationException $e){
            $errorMessage = $e->getMessage();
            return redirect()->back()->with('error', $errorMessage);
        }

    }
}
