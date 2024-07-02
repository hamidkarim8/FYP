<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use Carbon\Carbon;


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
}
