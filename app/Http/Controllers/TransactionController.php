<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['item', 'user'])->latest()->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $items = Item::all();
        return view('transactions.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $item = Item::findOrFail($request->item_id);

        if ($request->type === 'out' && $item->stock < $request->quantity) {
            return back()->with('error', 'Insufficient stock for this item.');
        }

        $transaction = Transaction::create([
            'item_id' => $request->item_id,
            'user_id' => auth()->id(),
            'type' => $request->type,
            'quantity' => $request->quantity,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        // Update item stock
        if ($request->type === 'in') {
            $item->increment('stock', $request->quantity);
        } else {
            $item->decrement('stock', $request->quantity);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }
}