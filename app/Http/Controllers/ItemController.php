<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use App\Notifications\EditItemDetails;
use App\Notifications\DeleteItemDetails;
use App\Notifications\ResolvedItemDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class ItemController extends Controller
{

    public function itemDetail($id)
    {
        $report = Report::with('item.category')->with('checkRequests')->where('type', 'detailed')->findOrFail($id);

        $item = $report->item;
        if (is_string($item->image_paths)) {
            $item->image_paths = json_decode($item->image_paths, true);
        }

        if (is_string($item->social_media)) {
            $item->social_media = json_decode($item->social_media, true);
        }

        if (is_string($item->location)) {
            $item->location = json_decode($item->location, true);
        }

        // dd($report);
        return view('item-detail', compact('report'));
    }
    public function edit($id)
    {
        $report = Report::with('item.category')->findOrFail($id);

        $item = $report->item;
        if (is_string($item->image_paths)) {
            $item->image_paths = json_decode($item->image_paths, true);
        }

        if (is_string($item->social_media)) {
            $item->social_media = json_decode($item->social_media, true);
        }

        if (is_string($item->location)) {
            $item->location = json_decode($item->location, true);
        }

        return response()->json(['report' => $report]);
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $item = $report->item;

        $request->validate([
            'title' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'description' => 'required|string',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'ig_username' => 'nullable|string',
            'twt_username' => 'nullable|string',
            'tt_username' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $item->fullname = $request->input('fullname');
        $item->title = $request->input('title');
        $item->description = $request->input('description');
        $item->phone_number = $request->input('phone_number');
        $item->email = $request->input('email');
        $item->social_media = json_encode([
            'ig_username' => $request->input('ig_username'),
            'twitter_username' => $request->input('twt_username'),
            'tiktok_username' => $request->input('tt_username'),
        ]);

        $item->save();

        DB::table('items')->where('id', $item->id)->update(['date' => $request->input('date')]);

        //send notification successfully updated item details
        $user = Auth::user();
        Notification::send($user, new EditItemDetails($report));

        return response()->json(['status' => 'success', 'message' => 'Report updated successfully']);
    }


    public function delete($id)
    {
        // Start a transaction to ensure both operations succeed or fail together
        DB::beginTransaction();
    
        try {
            // Find the report
            $report = Report::findOrFail($id);
    
            // Retrieve the associated item
            $item = $report->item;
    
            // Delete the report
            $report->delete();
    
            // Delete the associated item
            if ($item) {
                $item->delete();
            }
    
            // Commit the transaction
            DB::commit();
    
            // Send notification successfully updated item details
            $user = Auth::user();
            Notification::send($user, new DeleteItemDetails($report));
    
            return response()->json(['status' => 'success', 'message' => 'Report and associated item deleted successfully']);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();
    
            // Log the error
            Log::error('Error deleting report and associated item: ' . $e->getMessage());
    
            return response()->json(['status' => 'error', 'message' => 'Failed to delete report and associated item']);
        }
    }
    public function latestReport()
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not authenticated. Please log in to use this feature',
                ], 401);
            }

            $user = User::find(Auth::id());

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                ], 404);
            }

            $latestReport = $user->reports()->latest()->first();

            if ($latestReport) {
                
                $similarItems = $latestReport->getSimilarItems();

                return response()->json([
                    'success' => true,
                    'report' => $latestReport,
                    'similarItems' => $similarItems,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No report found for the user.',
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching latest report: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error fetching latest report. Please try again later.',
            ], 500);
        }
    }
    public function resolved(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $report->isResolved = "Resolved";
        $report->save();

        //send notification successfully updated item details
        $user = Auth::user();
        Notification::send($user, new ResolvedItemDetails($report));

        return response()->json(['status' => 'success', 'message' => 'Report resolved successfully']);
    }
}
