<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Models\DeletedReport;
use App\Models\Profile;
use App\Models\Feedback;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function adminIndex()
    {
        // Fetch data for detailed reports
        $detailedReports = Report::with(['item', 'item.category'])
            ->where('type', 'detailed')
            ->get();

        // Fetch data for simple reports
        $simpleReports = Report::with(['item', 'item.category'])
            ->where('type', 'simple')
            ->get();

        // Fetch data for all reports
        $allReports = Report::with(['item', 'item.category'])
            ->get();

        // Fetch data for resolved detailed reports
        $resolvedReports = Report::with(['item', 'item.category'])
            ->where('type', 'detailed')
            ->where('isResolved', 'resolved')
            ->get();

        // Fetch data for normal users
        $normalUsers = User::where('role', 'normal_user')
            ->get();

        // Calculate previous week's data
        $previousWeekStartDate = Carbon::now()->subWeek()->startOfWeek();
        $previousWeekEndDate = Carbon::now()->subWeek()->endOfWeek();

        // Example logic to fetch previous week's counts
        $simpleReportsPreviousWeekCount = Report::where('type', 'simple')
            ->whereBetween('created_at', [$previousWeekStartDate, $previousWeekEndDate])
            ->count();

        $detailedReportsPreviousWeekCount = Report::where('type', 'detailed')
            ->whereBetween('created_at', [$previousWeekStartDate, $previousWeekEndDate])
            ->count();

        $resolvedReportsPreviousWeekCount = Report::where('type', 'detailed')
            ->where('isResolved', 'resolved')
            ->whereBetween('created_at', [$previousWeekStartDate, $previousWeekEndDate])
            ->count();

        $normalUsersPreviousWeekCount = User::where('role', 'normal_user')
            ->whereBetween('created_at', [$previousWeekStartDate, $previousWeekEndDate])
            ->count();

        // Calculate percentage changes
        $simpleReportsPercentageChange = $this->calculatePercentageChange($simpleReports->count(), $simpleReportsPreviousWeekCount);
        $detailedReportsPercentageChange = $this->calculatePercentageChange($detailedReports->count(), $detailedReportsPreviousWeekCount);
        $resolvedReportsPercentageChange = $this->calculatePercentageChange($resolvedReports->count(), $resolvedReportsPreviousWeekCount);
        $normalUsersPercentageChange = $this->calculatePercentageChange($normalUsers->count(), $normalUsersPreviousWeekCount);

        // Pass data to the view
        return view('admin.index', compact('detailedReports', 'simpleReports', 'resolvedReports', 'normalUsers', 'simpleReportsPercentageChange', 'detailedReportsPercentageChange', 'resolvedReportsPercentageChange', 'normalUsersPercentageChange', 'allReports'));
    }

    // Function to calculate percentage change
    public function calculatePercentageChange($currentValue, $previousValue)
    {
        if ($previousValue > 0) {
            return number_format(($currentValue - $previousValue) / $previousValue * 100, 2);
        } else {
            return 0;
        }
    }
    public function displayReports()
    {
        return view('admin.reports');
    }
    public function displayAdmins()
    {
        return view('admin.admins');
    }
    public function displayUsers()
    {
        return view('admin.users');
    }
    public function displayFeedbacks()
    {
        return view('admin.feedbacks');
    }

    public function getReports(Request $request)
    {
        // dd($request);

        if ($request->ajax()) {
            $data = Report::with('item', 'user.profile')->get();
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                                <a href="#" role="button" id="dropdownMenuLink' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-2-fill"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink' . $row->id . '">
                                    <li><a class="dropdown-item view-report" href="#" data-id="' . $row->id . '">View</a></li>
                                    <li><a class="dropdown-item delete-report" href="#" data-id="' . $row->id . '">Delete</a></li>
                                </ul>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function viewReport($id)
    {
        // dd($id);

        $report = Report::with('item', 'item.category', 'user.profile')->find($id);
        // dd($report);
        if ($report) {
            return response()->json($report);
        }
        return response()->json(['error' => 'Report not found.'], 404);
    }

    public function deleteReport(Request $request, $id)
    {
        $report = Report::find($id);
        if ($report) {
            DeletedReport::create([
                'report_id' => $report->id,
                'deleted_type' => $request->deleted_type,
                'remarks' => $request->remarks,
            ]);
            $report->delete();
            return response()->json(['success' => 'Report deleted successfully.']);
        }
        return response()->json(['error' => 'Report not found.'], 404);
    }

    public function getAdmins(Request $request)
    {
        // dd($request);

        if ($request->ajax()) {
            $data = User::with('profile')->where('role', 'admin')->get();
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                                <a href="#" role="button" id="dropdownMenuLink' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-2-fill"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink' . $row->id . '">
                                    <li><a class="dropdown-item view-admin" href="#" data-id="' . $row->id . '">View</a></li>
                                    <li><a class="dropdown-item delete-admin" href="#" data-id="' . $row->id . '">Delete</a></li>
                                </ul>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function viewAdmin($id)
    {
        $admin = User::with('profile')->where('role', 'admin')->where('id', $id)->first();
        if ($admin) {
            return response()->json($admin);
        }
        return response()->json(['error' => 'Admin not found.'], 404);
    }
    public function deleteAdmin($id)
    {
        $admin = User::find($id);

        // Check if admin exists
        if (!$admin) {
            return response()->json(['error' => 'Admin not found.'], 404);
        }

        // Check if the admin is trying to delete themselves
        if ($admin->id === auth()->user()->id) {
            return response()->json(['error' => 'You cannot delete yourself.'], 403);
        }

        // Check if this is the last admin user in the system
        if ($admin->role === 'admin' && User::where('role', 'admin')->count() === 1) {
            return response()->json(['error' => 'Cannot delete the last admin user.'], 403);
        }

        // Delete the admin user
        $admin->delete();

        return response()->json(['success' => 'Admin deleted successfully.']);
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,name',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin',
        ], [
            'email.required' => 'Please enter an email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already taken.',
            'username.required' => 'Please enter a username.',
            'username.string' => 'Username must be a string.',
            'username.max' => 'Username must not exceed 255 characters.',
            'username.unique' => 'This username is already taken.',
            'password.required' => 'Please enter a password.',
            'password.string' => 'Password must be a string.',
            'password.min' => 'Password must be at least 8 characters long.',
            'role.required' => 'Please select a role.',
            'role.string' => 'Role must be a string.',
            'role.in' => 'Invalid role selected.',
        ]);

        // Create admin user
        $admin = User::create([
            'email' => $request->email,
            'name' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        Profile::create([
            'user_id' => $admin->id,
        ]);

        return response()->json(['success' => 'Admin added successfully']);
    }

    public function getUsers(Request $request)
    {
        // dd($request);

        if ($request->ajax()) {
            $data = User::with('profile')->where('role', 'normal_user')->get();
            // dd($data);
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                                <a href="#" role="button" id="dropdownMenuLink' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-2-fill"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink' . $row->id . '">
                                    <li><a class="dropdown-item view-user" href="#" data-id="' . $row->id . '">View</a></li>
                                </ul>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function viewUser($id)
    {
        $user = User::with('profile')->where('role', 'normal_user')->where('id', $id)->first();
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['error' => 'User not found.'], 404);
    }
    public function getFeedbacks(Request $request)
    {
        if ($request->ajax()) {
            $data = Feedback::with('user.profile')->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $displayOption = $row->isDisplay ? 'Remove Display' : 'Set Display';
                    $btn = '<div class="dropdown">
                                <a href="#" role="button" id="dropdownMenuLink' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-2-fill"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink' . $row->id . '">
                                    <li><a class="dropdown-item view-feedback" href="#" data-id="' . $row->id . '">View</a></li>
                                    <li><a class="dropdown-item reply-feedback" href="#" data-id="' . $row->id . '">Reply</a></li>
                                    <li><a class="dropdown-item delete-feedback" href="#" data-id="' . $row->id . '">Delete</a></li>
                                    <li><a class="dropdown-item toggle-display" href="#" data-id="' . $row->id . '" data-display="' . $row->isDisplay . '">' . $displayOption . '</a></li>
                                </ul>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    
    public function viewFeedback($id)
    {
        $feedback = Feedback::with('user.profile')->where('id', $id)->first();
        if ($feedback) {
            return response()->json($feedback);
        }
        return response()->json(['error' => 'Feedback not found.'], 404);
    }

    public function deleteFeedback($id)
    {
        $feedback = Feedback::find($id);

        // Check if feedback exists
        if (!$feedback) {
            return response()->json(['error' => 'Feedback not found.'], 404);
        }
        // Delete the feedback
        $feedback->delete();

        return response()->json(['success' => 'Feedback deleted successfully.']);
    }

    public function replyFeedback(Request $request)
    {
        $validatedData = $request->validate([
            'feedback_id' => 'required|exists:feedbacks,id',
            'reply' => 'required|string|max:1000',
        ], [
            'reply.required' => 'Please enter a reply.',
        ]);

        try {
            $feedback = Feedback::findOrFail($validatedData['feedback_id']);
            $feedback->reply = $validatedData['reply'];
            $feedback->save();

            return response()->json(['success' => 'Reply sent successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while replying to feedback.'], 500);
        }
    }
    public function toggleDisplay(Request $request)
{
    $request->validate([
        'feedback_id' => 'required|exists:feedbacks,id',
        'isDisplay' => 'required|boolean',
    ]);

    $feedback = Feedback::find($request->feedback_id);
    if ($feedback) {
        $feedback->isDisplay = $request->isDisplay;
        $feedback->save();

        return response()->json(['success' => 'Display status updated successfully.']);
    }

    return response()->json(['error' => 'Feedback not found.'], 404);
}
}
