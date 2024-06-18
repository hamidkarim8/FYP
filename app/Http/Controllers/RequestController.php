<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailedReport;
use App\Models\Request as ReportRequest;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function requestAction(Request $request, $reportId)
    {
        $report = DetailedReport::findOrFail($reportId);

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

        return response()->json(['status' => 'success', 'request' => $newRequest]);
    }

    public function acceptRequest(Request $request, $reportId)
    {
        $report = DetailedReport::findOrFail($reportId);
        $contactRequest = ReportRequest::where('detailed_report_id', $reportId)
            ->where('status', 'pending')
            ->first();

        if ($contactRequest) {
            $contactRequest->status = 'approved';
            $contactRequest->save();
        }

        return response()->json(['status' => 'success']);
    }
}
