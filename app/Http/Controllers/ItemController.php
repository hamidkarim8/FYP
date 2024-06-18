<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
