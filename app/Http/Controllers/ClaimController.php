<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Claim;

class ClaimController extends Controller
{
    public function fetchClaimerInfo($reportId)
    {
        // Find the claim related to the report ID
        $claim = Claim::where('report_id', $reportId)->first();

        if ($claim) {
            // Find the request related to the claim
            $request = $claim->request;

            if ($request) {
                // Get the user associated with the request
                $user = $request->user;

                if ($user) {
                    // Prepare the data to be sent back
                    $claimerData = [
                        'fullname' => $user->profile->fullname ?? 'Not provided',
                        'username' => $user->name ?? 'Not provided',
                        'email' => $user->email ?? 'Not provided',
                        'address' => $user->profile->address ?? 'Not provided',
                        'requestDate' => $request->created_at ?? 'Not provided',
                        'phoneNumber' => $user->profile->phone_number ?? 'Not provided',
                        'socialMedia' => $user->profile->social_media ?? '{}'
                    ];

                    return response()->json(['claimer' => $claimerData]);
                }
            }
        }

        // Return an empty response if no claim or request is found
        return response()->json(['claimer' => []]);
    }
}

