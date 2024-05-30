<?php

namespace App\Http\Controllers;
use App\Models\LostItem;

use Illuminate\Http\Request;

class LostItemController extends Controller
{
    public function index()
    {
        $lostItems = LostItem::all();
        return view('lost-items.index', compact('lostItems'));
    }}
