<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemSize; // NEW: Import ItemSize model
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
        // UPDATE: Eager load Unit dan Sizes agar data stok per ukuran tersedia
        // untuk logika JavaScript placeholder di frontend.
        $items = Item::with('unit', 'sizes')->get(); 
        return view('transactions.create', compact('items'));
    }

    public function store(Request $request)
    {
        // UPDATE: Validasi item_size_id dan hapus validasi default total item stock
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'item_size_id' => 'required|exists:item_sizes,id', // NEW: Validasi ID ukuran
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        // Cari itemSize dan parent item-nya
        $itemSize = ItemSize::findOrFail($request->item_size_id); // Cari varian ukuran yang dipilih
        $item = $itemSize->item; // Ambil item utama

        // Validasi Stok per Ukuran
        if ($request->type === 'out' && $itemSize->stock < $request->quantity) {
            return back()->withInput()->with('error', 'Stok ukuran ' . $itemSize->size . ' tidak mencukupi.');
        }

        // Simpan Transaksi
        $transaction = Transaction::create([
            'item_id' => $request->item_id,
            'item_size_id' => $request->item_size_id, // NEW: Simpan ID varian ukuran
            'user_id' => auth()->id(),
            'type' => $request->type,
            'quantity' => $request->quantity,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        // UPDATE: Perbarui stok di ItemSize dan Item (total stok)
        if ($request->type === 'in') {
            // Tambah stok varian
            $itemSize->increment('stock', $request->quantity);
            // Tambah total stok item
            $item->increment('stock', $request->quantity); 
        } else {
            // Kurangi stok varian
            $itemSize->decrement('stock', $request->quantity);
            // Kurangi total stok item
            $item->decrement('stock', $request->quantity); 
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }
}