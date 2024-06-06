<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function adminIndex()
    {
        $countUser = User::count();
        $countFound = Item::where('type', 'found')->count();
        $countLost = Item::where('type', 'lost')->count();

        return view('admin.index', compact('countUser', 'countFound', 'countLost'));
    }}
