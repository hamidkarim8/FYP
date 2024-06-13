<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DetailedReport;


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

        return view('index', compact('detailedReports'));
    }
}
