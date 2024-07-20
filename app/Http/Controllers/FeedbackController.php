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
        try {
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
    
            // Send notifications
            $user = Auth::user();
            Notification::send($user, new FeedbackSubmitted($feedback));
    
            // Send notification to admin
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new FeedbackToReview($feedback));
    
            return response()->json(['success' => 'Feedback submitted successfully.']);
        } catch (\Exception $e) {
            // Return error response
            return response()->json(['error' => 'Failed to submit feedback. Please try again.'], 500);
        }
    }
}
