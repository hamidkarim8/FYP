<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Request as ReportRequest;
use App\Notifications\IncomingRequests;
use App\Notifications\RequestsSubmitted;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\ApproveRequests;
use App\Notifications\DeclineRequests;
use App\Notifications\RequestApproved;
use App\Notifications\RequestDeclined;

class RequestController extends Controller
{
    public function requestAction(Request $request, $reportId)
    {
        $report = Report::findOrFail($reportId);
        // dd($report->user_id);
        $userToBeNotified = User::findOrFail($report->user_id);
        // dd($userToBeNotified->id);
        $existingRequest = ReportRequest::where('detailed_report_id', $reportId)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return response()->json(['status' => 'error', 'message' => 'Request already exists']);
        }

        $newRequest = ReportRequest::create([
            'detailed_report_id' => $reportId,
            'user_id' => Auth::id(),
            'type' => $request->type,
            'status' => 'pending'
        ]);

        //send notification with status
        $user = Auth::user();
        Notification::send($user, new RequestsSubmitted($newRequest));

        //send incoming request to reporter
        $userToBeNotified->notify(new IncomingRequests($newRequest));

        return response()->json(['status' => 'success', 'request' => $newRequest]);
    }

    public function acceptRequestById(Request $request, $requestId)
    {
        $contactRequest = ReportRequest::findOrFail($requestId);
        $userToBeNotified = User::findOrFail($contactRequest->user_id);

        if ($contactRequest->status == 'pending') {
            $contactRequest->status = 'approved';
            $contactRequest->save();
        }

        //send notification approved
        $user = Auth::user();
        Notification::send($user, new ApproveRequests($contactRequest));

        //send notification to the requester
        $userToBeNotified->notify(new RequestApproved($contactRequest));

        return response()->json(['status' => 'success']);
    }
    public function declineRequestById(Request $request, $requestId)
    {
        $contactRequest = ReportRequest::findOrFail($requestId);
        $userToBeNotified = User::findOrFail($contactRequest->user_id);

        if ($contactRequest->status == 'pending') {
            $contactRequest->status = 'declined';
            $contactRequest->save();
        }

        //send notification declined
        $user = Auth::user();
        Notification::send($user, new DeclineRequests($contactRequest));

        //send notification to the requester
        $userToBeNotified->notify(new RequestDeclined($contactRequest));

        return response()->json(['status' => 'success']);
    }
    public function getRequests($reportId)
    {
        $requests = ReportRequest::where('detailed_report_id', $reportId)
            ->where('status', 'pending')
            ->with('user')
            ->with('profile')
            ->get();
        // dd($requests);
        return response()->json(['requests' => $requests]);
    }
}
