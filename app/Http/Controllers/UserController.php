<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DetailedReport;
use App\Models\SimpleReport;


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
        $detailedReports = DetailedReport::with('category')->get();
        $simpleReports = SimpleReport::with('category')->get();
        $normalUsers = User::where('role', 'normal_user')->get();
        // dd($detailedReports);
        return view('index', compact('detailedReports','simpleReports','normalUsers'));
    }
}
