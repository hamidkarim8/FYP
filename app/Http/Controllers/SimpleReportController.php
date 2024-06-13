<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\SimpleReport;
use App\Models\Category;
use Carbon\Carbon;

class SimpleReportController extends Controller
{
    public function show()
    {
        $reports = SimpleReport::with('category')->get();

        $response = $reports->map(function ($report) {
            return [
                'title' => $report->title,
                'type' => $report->type,
                'category' => $report->category ? $report->category->name : null,
                'location' => [
                    'lat' => $report->location['lat'],
                    'lng' => $report->location['lng'],
                    'desc' => $report->location['desc'],
                ],
                'date' => Carbon::parse($report->date)->format('d-m-Y'),
            ];
        });

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
            'in' => 'The selected :attribute is invalid.',
            'exists' => 'The selected :attribute is invalid.',
            'numeric' => 'The :attribute must be a number.',
            'date' => 'The :attribute must be a valid date.',
        ];
    
        try {
            $validatedData = $request->validate([
                'title' => 'nullable|string',
                'type' => 'required|in:found,lost',
                'category_id' => 'required|exists:categories,id',
                'description' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'date' => 'required|date',
            ], $messages);
    
            // Create and save new report
            $report = new SimpleReport();
            $report->id = Str::uuid();
            $report->title = $validatedData['title'];
            $report->type = $validatedData['type'];
            $report->category_id = $validatedData['category_id'];
            $report->location = [
                'lat' => $validatedData['latitude'],
                'lng' => $validatedData['longitude'],
                'desc' => $validatedData['description'],
            ];
            $report->date = $validatedData['date'];
            $report->save();
    
            return response()->json(['message' => 'Report submitted successfully'], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    
}
