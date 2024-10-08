<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Notifications\SimpleReportSubmitted;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File as FileFacade;
use App\Models\Report;
use App\Models\User;
use App\Notifications\DetailedReportSubmitted;
use Carbon\Carbon;
use App\Notifications\ReportSubmitted;
use App\Notifications\SimilarItem;

class ReportController extends Controller
{
    public function showSimpleReport()
    {
        $reports = Report::with('item.category')->where('type', 'simple')->get();

        $response = $reports->map(function ($report) {
            return [
                'title' => $report->item->title,
                'type' => $report->item->type,
                'category' => $report->item->category ? $report->item->category->name : null,
                'location' => [
                    'lat' => $report->item->location['lat'],
                    'lng' => $report->item->location['lng'],
                    'desc' => $report->item->location['desc'],
                ],
                'date' => Carbon::parse($report->item->date)->format('d/m/Y'),
            ];
        });

        return response()->json($response);
    }

    public function storeSimpleReport(Request $request)
    {
        $messages = [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',

            'type.required' => 'The type field is required.',
            'type.in' => 'The selected type is invalid.',

            'category_id.required' => 'The category field is required.',
            'category_id.exists' => 'The selected category is invalid.',

            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',

            'latitude.required' => 'The latitude field is required.',
            'latitude.numeric' => 'The latitude must be a number.',

            'longitude.required' => 'The longitude field is required.',
            'longitude.numeric' => 'The longitude must be a number.',

            'date.required' => 'The date field is required.',
            'date.date' => 'The date must be a valid date.',
        ];

        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'type' => 'required|in:found,lost',
                'category_id' => 'required|exists:categories,id',
                'description' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'date' => 'required|date',
            ], $messages);


            // Create the item record
            $item = new Item();
            $item->title = $validatedData['title'];
            $item->type = $validatedData['type'];
            $item->category_id = $validatedData['category_id'];
            $item->location = [
                'lat' => $validatedData['latitude'],
                'lng' => $validatedData['longitude'],
                'desc' => $validatedData['description'],
            ];
            $item->date = $validatedData['date'];
            $item->save();

            // Create the report record
            $report = new Report();
            $report->id = Str::uuid();
            $report->item_id = $item->id;
            $report->type = 'simple';
            $report->save();

            //send notification successfully submitted a report
            $user = Auth::user();
            if ($user) {
                Notification::send($user, new SimpleReportSubmitted($report));
            }

            return response()->json(['message' => 'Report submitted successfully'], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    public function process(Request $request): string
    {
        /** @var UploadedFile[] $files */
        $files = $request->allFiles();

        if (empty($files)) {
            abort(422, 'No files were uploaded.');
        }

        if (count($files) > 1) {
            abort(422, 'Only 1 file can be uploaded at a time.');
        }


        $requestKey = array_key_first($files);


        $file = is_array($request->input($requestKey))
            ? $request->file($requestKey)[0]
            : $request->file($requestKey);


        $filePath = $file->store('tmp/' . now()->timestamp . '-' . Str::random(20));

        // Log the file path for debugging
        Log::info('File stored at: ' . $filePath);

        // Return the file path
        return $filePath;
    }

    public function submitDetailedReport(Request $request)
    {
        // dd($request->all());
        // if ($request->has('detailed-images')        ) {
        //     dd($request->all());
        //     $file = $request->file('detailed-images');
        //     // Process the uploaded file
        //     $fileLocation = $file->store('imports'); // Store the file in the 'imports' directory
        //     // Add the file location to the validated data array if needed
        //     $validatedData['detailed-images'] = $fileLocation;
        // } else {
        //     // Handle case where no file is uploaded
        //     // Optionally, you can set a default file location or handle this case differently
        // }
        Log::info('Request received: ', $request->all());
        $messages = [
            'detailed-title.required' => 'The title field is required.',
            'detailed-title.string' => 'The title must be a string.',
            'detailed-title.max' => 'The title may not be greater than 255 characters.',

            'detailed-type.required' => 'The type field is required.',
            'detailed-type.in' => 'The selected type is invalid.',

            'detailed-category.required' => 'The category field is required.',
            'detailed-category.exists' => 'The selected category is invalid.',

            'detailed-description.string' => 'The description must be a string.',

            'detailed-images.required' => 'The images field is required.',

            'detailed-latitude.required' => 'The latitude field is required.',
            'detailed-latitude.numeric' => 'The latitude must be a number.',

            'detailed-longitude.required' => 'The longitude field is required.',
            'detailed-longitude.numeric' => 'The longitude must be a number.',

            'detailed-loc-desc.string' => 'The location description must be a string.',

            'detailed-fullname.required' => 'The full name field is required.',
            'detailed-fullname.string' => 'The full name must be a string.',
            'detailed-fullname.max' => 'The full name may not be greater than 255 characters.',

            'detailed-email.required' => 'The email field is required.',
            'detailed-email.email' => 'The email must be a valid email address.',
            'detailed-email.max' => 'The email may not be greater than 255 characters.',

            'detailed-phone.required' => 'The phone number field is required.',
            'detailed-phone.string' => 'The phone number must be a string.',
            'detailed-phone.max' => 'The phone number may not be greater than 20 characters.',

            'ig_username.string' => 'The Instagram username must be a string.',
            'ig_username.max' => 'The Instagram username may not be greater than 255 characters.',

            'twitter_username.string' => 'The Twitter username must be a string.',
            'twitter_username.max' => 'The Twitter username may not be greater than 255 characters.',

            'tiktok_username.string' => 'The TikTok username must be a string.',
            'tiktok_username.max' => 'The TikTok username may not be greater than 255 characters.',

            'detailed-date.required' => 'The detailed date field is required.',
            'detailed-date.date' => 'The detailed date must be a valid date.',
        ];

        try {
            $validatedData = $request->validate([
                'detailed-title' => 'required|string|max:255',
                'detailed-type' => 'required|in:found,lost',
                'detailed-category' => 'required|exists:categories,id',
                'detailed-description' => 'nullable|string',
                'detailed-images' => 'required',
                'detailed-latitude' => 'required|numeric',
                'detailed-longitude' => 'required|numeric',
                'detailed-loc-desc' => 'nullable|string',
                'detailed-fullname' => 'required|string|max:255',
                'detailed-email' => 'required|email|max:255',
                'detailed-phone' => 'required|string|max:20',
                'ig_username' => 'nullable|string|max:255',
                'twitter_username' => 'nullable|string|max:255',
                'tiktok_username' => 'nullable|string|max:255',
                'detailed-date' => 'required|date',
            ], $messages);
            // Copy the file from a temporary location to a permanent location.
            $fileLocations = [];
            if ($request->has('detailed-images')) {
                $tmpFilePaths = $request->input('detailed-images');

                foreach ($tmpFilePaths as $tmpFilePath) {
                    $fullTmpPath = storage_path('app/' . $tmpFilePath);

                    if (FileFacade::exists($fullTmpPath)) {
                        // Move the file to a permanent location in the public directory
                        $fileName = time() . '_' . basename($tmpFilePath); // Generate a unique filename
                        $newFilePath = public_path('item-images') . '/' . $fileName;

                        // Move the file from the temporary location to the public directory
                        if (rename($fullTmpPath, $newFilePath)) {
                            Log::info('File moved to: ' . $newFilePath);
                            $fileLocations[] = 'item-images/' . $fileName; // Store the file path
                        } else {
                            Log::error('Failed to move file from ' . $fullTmpPath . ' to ' . $newFilePath);
                        }
                    } else {
                        Log::error('File does not exist: ' . $fullTmpPath);
                    }
                }
            }

            // Create the item record
            $item = new Item();
            $item->title = $validatedData['detailed-title'];
            $item->type = $validatedData['detailed-type'];
            $item->category_id = $validatedData['detailed-category'];
            $item->description = $validatedData['detailed-description'];
            $item->image_paths = json_encode($fileLocations);
            $item->fullname = $validatedData['detailed-fullname'];
            $item->email = $validatedData['detailed-email'];
            $item->phone_number = $validatedData['detailed-phone'];
            $item->location = [
                'lat' => $request->input('detailed-latitude'),
                'lng' => $request->input('detailed-longitude'),
                'desc' => $request->input('detailed-loc-desc'),
            ];
            $item->social_media = [
                'ig_username' => $request->input('ig_username'),
                'twitter_username' => $request->input('twitter_username'),
                'tiktok_username' => $request->input('tiktok_username'),
            ];
            $item->date = $validatedData['detailed-date'];
            $item->save();

            // Create the report record
            $report = new Report();
            $report->id = Str::uuid();
            $report->user_id = Auth::id();
            $report->item_id = $item->id;
            $report->type = 'detailed';
            $report->save();

            //send notification successfully submitted a report
            $user = Auth::user();
            Notification::send($user, new DetailedReportSubmitted($report));

            //send notification to those who reported similar item
            $this->notifyUsers($report);

            return redirect()->back()->with('success', 'Detailed report submitted successfully.');
        } catch (ValidationException $e) {
            $errorMessage = $e->getMessage();
            Log::error('Error submitting detailed report: ' . $errorMessage);
            return redirect()->back()->with('error', $errorMessage);
        }
    }
    protected function notifyUsers($report)
    {
        $authUserId = Auth::id();
        
        Log::info('Authenticated User ID: ' . $authUserId);
        Log::info('Report: ', $report->toArray());
        
        // Extract the desc value from the report's item's location
        $desc = $report->item->location['desc'];
        $descWords = array_filter(explode(' ', $desc)); // Split the desc into words
        $descPattern = implode('|', array_map('preg_quote', $descWords)); // Create a regex pattern from the words
        $descPatternLower = strtolower($descPattern); // Convert the pattern to lowercase
        
        // Log the regex pattern
        Log::info('Regex pattern for location desc: ' . $descPatternLower);
        
        // Testing: Find matching reports
        $matchingReports = Report::whereHas('item', function ($itemQuery) use ($report, $descPatternLower) {
            $itemQuery->where('title', 'like', '%' . $report->item->title . '%')
                ->orWhere('category_id', $report->item->category_id)
                ->orWhereRaw('LOWER(JSON_EXTRACT(location, "$.desc")) REGEXP ?', [$descPatternLower]);
        })->where('type', 'detailed')->get();
        
        Log::info('Matching Reports: ', $matchingReports->toArray());
        
        // Find users to be notified
        $users = User::whereHas('reports', function ($query) use ($report, $authUserId, $descPatternLower) {
            $query->where('user_id', '!=', $authUserId)
                ->where('type', 'detailed')
                ->whereHas('item', function ($itemQuery) use ($report, $descPatternLower) {
                    $itemQuery->where('title', 'like', '%' . $report->item->title . '%')
                        ->orWhere('category_id', $report->item->category_id)
                        ->orWhereRaw('LOWER(JSON_EXTRACT(location, "$.desc")) REGEXP ?', [$descPatternLower]);
                });
        })->get();
        
        Log::info('Users to be notified: ', $users->toArray());
        
        foreach ($users as $user) {
            $user->notify(new SimilarItem($report->item, $report));
        }
    }
    
}
