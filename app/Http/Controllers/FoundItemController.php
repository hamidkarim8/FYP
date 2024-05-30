<?php

namespace App\Http\Controllers;

use App\Models\FoundItem;
use Illuminate\Http\Request;

class FoundItemController extends Controller
{
    public function index()
    {
        $foundItems = FoundItem::with('user')->get();
        // dd($foundItems);

        return view('pages-starter', compact('foundItems'));
    }
}