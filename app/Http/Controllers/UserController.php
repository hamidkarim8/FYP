<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
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
        $detailedReports = Report::with(['item', 'item.category'])->where('type', 'detailed')->get();
        $paginateDetailedReports = Report::with(['item', 'item.category'])->where('type', 'detailed')->paginate(6);
        $simpleReports = Report::with(['item', 'item.category'])->where('type', 'simple')->get();
        $normalUsers = User::where('role', 'normal_user')->get();
        // dd($detailedReports);
        return view('index', compact('detailedReports', 'simpleReports', 'normalUsers', 'paginateDetailedReports'));
    }
    public function myReports()
    {
        $authUserId = Auth::id();
        $detailedReports = Report::with(['item', 'item.category'])->where('type', 'detailed')->where('user_id', $authUserId)->get();
        $paginateDetailedReports = Report::with(['item', 'item.category'])->where('type', 'detailed')->where('user_id', $authUserId)->paginate(6);
        return view('my-reports', compact('detailedReports', 'paginateDetailedReports'));
    }
}
