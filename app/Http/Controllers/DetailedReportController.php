<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailedReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\File as FileFacade; // Use this facade to check file existence



class DetailedReportController extends Controller
{
    public function process(Request $request): string
    {
        // We don't know the name of the file input, so we need to grab
        // all the files from the request and grab the first file.
        /** @var UploadedFile[] $files */
        $files = $request->allFiles();

        if (empty($files)) {
            abort(422, 'No files were uploaded.');
        }

        if (count($files) > 1) {
            abort(422, 'Only 1 file can be uploaded at a time.');
        }

        // Now that we know there's only one key, we can grab it to get
        // the file from the request.
        $requestKey = array_key_first($files);

        // If we are allowing multiple files to be uploaded, the field in the
        // request will be an array with a single file rather than just a
        // single file (e.g. - `csv[]` rather than `csv`). So we need to
        // grab the first file from the array. Otherwise, we can assume
        // the uploaded file is for a single file input and we can
        // grab it directly from the request.
        $file = is_array($request->input($requestKey))
            ? $request->file($requestKey)[0]
            : $request->file($requestKey);

        // Store the file in a temporary location and return the location
        // for FilePond to use.
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
            'required' => 'The :attribute field is required.',
            'in' => 'The selected :attribute is invalid.',
            'exists' => 'The selected :attribute is invalid.',
            'numeric' => 'The :attribute must be a number.',
            'date' => 'The :attribute must be a valid date.',
            // 'mimes' => 'The :attribute must be a file of type: :values.',
            // 'image' => 'The :attribute must be an image (jpeg, png, jpg, gif)',
            // 'detailed-images.*.mimes' => 'The :attribute must be a file of type: jpeg, png, jpg, gif.',
        ];

        try {
            $validatedData = $request->validate([
                'detailed-title' => 'required|string|max:255',
                'detailed-type' => 'required|in:found,lost',
                'detailed-category' => 'required|exists:categories,id',
                'detailed-description' => 'nullable|string',
                // 'detailed-images.*' => 'required|mimes:jpeg,png,jpg,gif',
                'detailed-images.*' => 'required',//need improvement
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

                
                // Log the temporary file paths
                Log::info('Temporary file paths: ', $tmpFilePaths);

                foreach ($tmpFilePaths as $tmpFilePath) {
                    $fullTmpPath = storage_path('app/' . $tmpFilePath);

                    // Log the full temporary file path
                    Log::info('Full temporary file path: ' . $fullTmpPath);

                    if (FileFacade::exists($fullTmpPath)) {
                        Log::info('File exists: ' . $fullTmpPath);

                        // Move the file to a permanent location
                        $newFilePath = Storage::putFile('imports', new File($fullTmpPath));

                        // Log the new file location
                        Log::info('File moved to: ' . $newFilePath);

                        // Verify the new file path
                        if (Storage::exists($newFilePath)) {
                            Log::info('New file path verified: ' . $newFilePath);

                            // Add the new file path to the array
                            $fileLocations[] = $newFilePath;
                        } else {
                            Log::error('New file path does not exist: ' . $newFilePath);
                        }
                    } else {
                        Log::error('File does not exist: ' . $fullTmpPath);
                    }
                }
            }

            $report = new DetailedReport();
            $report->id = Str::uuid();
            $report->fullname = $validatedData['detailed-fullname'];
            $report->email = $validatedData['detailed-email'];
            $report->phone_number = $validatedData['detailed-phone'];
            $report->title = $validatedData['detailed-title'];
            $report->type = $validatedData['detailed-type'];
            $report->category_id = $validatedData['detailed-category'];
            $report->description = $validatedData['detailed-description'];
            $report->user_id = Auth::id();
            $report->location = [
                'lat' => $request->input('detailed-latitude'),
                'lng' => $request->input('detailed-longitude'),
                'desc' => $request->input('detailed-loc-desc'),
            ];
            $report->social_media = [
                'ig_username' => $request->input('ig_username'),
                'twitter_username' => $request->input('twitter_username'),
                'tiktok_username' => $request->input('tiktok_username'),
            ];

            $report->image_paths = json_encode($fileLocations);
            $report->save();

            return redirect()->back()->with('success', 'Detailed report submitted successfully.');
        } catch (ValidationException $e) {
            $errorMessage = $e->getMessage();
            Log::error('Error submitting detailed report: ' . $errorMessage);
            return redirect()->back()->with('error', $errorMessage);
        }
    }
}
