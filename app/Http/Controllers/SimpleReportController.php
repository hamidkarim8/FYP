<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\SimpleReport;


class SimpleReportController extends Controller
{
    public function show()
    {
        $reports = SimpleReport::all();
        return response()->json($reports);
    }
    public function store(Request $request)
    {

        $messages = [
            'required' => 'The :attribute field is required.',
            'in' => 'The selected :attribute is invalid.',
            'numeric' => 'The :attribute must be a number.',
            'date' => 'The :attribute must be a valid date.',
        ];

        // Validate the request data
        $validatedData = $request->validate([
            'type' => 'required|in:found,lost',
            'category' => 'nullable|string',
            'description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'date' => 'required|date',
        ], $messages);

        // Create and save new report
        $report = new SimpleReport();
        $report->id = Str::uuid(); 
        $report->type = $validatedData['type'];
        $report->category = $validatedData['category'];
        $report->location = [
            'lat' => $validatedData['latitude'],
            'lng' => $validatedData['longitude'],
            'desc' => $validatedData['description'],
        ];
        $report->date = $validatedData['date'];
        $report->save();

        // return response()->json(['message' => 'Report submitted successfully'], 200);
        if ($report) {
            return redirect()->back()->with('success', 'Thanks for your report.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }}
