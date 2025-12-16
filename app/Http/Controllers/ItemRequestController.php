<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ItemRequest::with(['item', 'user', 'processedBy']);

        if (auth()->user()->isStaff()) {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->latest()->paginate(10);
        return view('item-requests.index', compact('requests'));
    }

    public function create()
    {
        $items = Item::all();
        return view('item-requests.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string',
            'size' => 'nullable|string', 
        ]);

        $item = Item::findOrFail($request->item_id);
        $sizeId = null; // Default null (jika barang tidak punya ukuran)

        // LOGIKA BARU: Cari & Simpan ID Ukuran
        if ($request->filled('size')) {
            $itemSize = $item->sizes()->where('size', $request->size)->first();
            
            if (!$itemSize) {
                return back()->withInput()->with('error', "Ukuran '{$request->size}' tidak ditemukan.");
            }

            // Simpan ID ukuran ke variabel
            $sizeId = $itemSize->id;

            if ($request->quantity > $itemSize->stock) {
                return back()->withInput()->with('error', "Stok ukuran {$request->size} tidak cukup (Sisa: {$itemSize->stock})");
            }
        } else {
            if ($request->quantity > $item->stock) {
                return back()->withInput()->with('error', 'Jumlah permintaan melebihi stok tersedia.');
            }
        }

        // Simpan ke Database (Pastikan kolom item_size_id terisi)
        ItemRequest::create([
            'item_id' => $request->item_id,
            'user_id' => auth()->id(),
            'item_size_id' => $sizeId, // <--- INI YANG PENTING
            'size' => $request->size,
            'quantity' => $request->quantity,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('item-requests.index')->with('success', 'Permintaan berhasil dikirim.');
    }

    public function approve(ItemRequest $itemRequest)
    {
        if ($itemRequest->status !== 'pending') {
            return back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        $item = $itemRequest->item;

        // Validasi Stok Lagi sebelum approve
        if ($itemRequest->item_size_id) {
            $itemSize = \App\Models\ItemSize::find($itemRequest->item_size_id);
            if (!$itemSize || $itemSize->stock < $itemRequest->quantity) {
                return back()->with('error', 'Stok ukuran ini sudah habis, tidak bisa di-approve.');
            }
        } else {
            if ($item->stock < $itemRequest->quantity) {
                return back()->with('error', 'Stok total tidak mencukupi.');
            }
        }

        DB::transaction(function () use ($itemRequest, $item) {
            // 1. Update status jadi Approved
            $itemRequest->update([
                'status' => 'approved',
                'processed_by' => auth()->id(),
                'processed_at' => now(),
            ]);

            // 2. Buat Transaksi Keluar (Bawa data item_size_id)
            $item->transactions()->create([
                'user_id' => $itemRequest->user_id,
                'item_size_id' => $itemRequest->item_size_id, // <--- INI PENTING AGAR RELASI NYAMBUNG
                'type' => 'out',
                'quantity' => $itemRequest->quantity,
                'date' => now(),
                'note' => 'Approved request #' . $itemRequest->id . ($itemRequest->size ? " (Size: {$itemRequest->size})" : ""),
            ]);

            // 3. Kurangi Stok di Tabel Ukuran (ItemSize)
            if ($itemRequest->item_size_id) {
                $itemSize = \App\Models\ItemSize::find($itemRequest->item_size_id);
                if ($itemSize) {
                    $itemSize->decrement('stock', $itemRequest->quantity);
                }
            }

            // 4. Kurangi Stok Total Barang
            $item->decrement('stock', $itemRequest->quantity);
        });

        return redirect()->route('item-requests.index')->with('success', 'Permintaan disetujui & stok berhasil dikurangi.');
    }
    
    public function show(ItemRequest $itemRequest)
    {
        if (auth()->user()->isStaff() && $itemRequest->user_id != auth()->id()) {
            abort(403);
        }

        return view('item-requests.show', compact('itemRequest'));
    }

    public function reject(Request $request, ItemRequest $itemRequest)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        if ($itemRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $itemRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'processed_by' => auth()->id(),
            'processed_at' => now(),
        ]);

        return redirect()->route('item-requests.index')->with('success', 'Request rejected successfully.');
    }
}