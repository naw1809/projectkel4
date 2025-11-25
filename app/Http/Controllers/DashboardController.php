<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = Item::count();
        $pendingRequests = ItemRequest::where('status', 'pending')->count();
        $lowStockItems = Item::where('stock', '<', 10)->count();

        return view('dashboard', compact('totalItems', 'pendingRequests', 'lowStockItems'));
    }
}