<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function userIndex()
    {
        $detailedReports = Report::with(['item', 'item.category'])->where('type', 'detailed')->whereNot('isResolved', 'resolved')->get();
        $paginateDetailedReports = Report::with(['item', 'item.category'])->where('type', 'detailed')->whereNot('isResolved', 'resolved')->paginate(6);
        $simpleReports = Report::with(['item', 'item.category'])->where('type', 'simple')->get();
        $normalUsers = User::where('role', 'normal_user')->get();
        // dd($detailedReports);
        $resolvedReports = Report::with(['item', 'item.category'])->where('type', 'detailed')->where('isResolved', 'resolved')->get();
        $feedbacks = Feedback::where('isDisplay', true)->with('user')->get();
        return view('index', compact('detailedReports', 'simpleReports', 'normalUsers', 'paginateDetailedReports', 'resolvedReports', 'feedbacks'));
    }
    public function myReports()
    {
        $authUserId = Auth::id();
        $detailedReports = Report::with(['item', 'item.category'])->where('type', 'detailed')->where('user_id', $authUserId)->get();
        $paginateDetailedReports = Report::with(['item', 'item.category'])->where('type', 'detailed')->where('user_id', $authUserId)->paginate(6);
        return view('my-reports', compact('detailedReports', 'paginateDetailedReports'));
    }
}
