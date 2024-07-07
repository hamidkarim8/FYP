<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\FeedbackSubmitted;
use App\Notifications\FeedbackToReview;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:enhancement,comment,fraudulent',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $feedback = Feedback::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'type' => $request->type,
            'stars' => $request->rating,
            'isDisplay' => false,
        ]);

        //send notification successfully submitted a feedback
        $user = Auth::user();
        Notification::send($user, new FeedbackSubmitted($feedback));

        //send notification to review
        $admin = User::where('role', 'admin')->get();
        Notification::send($admin, new FeedbackToReview($feedback));

        return response()->json(['success' => 'Feedback submitted successfully.']);
    }
}
