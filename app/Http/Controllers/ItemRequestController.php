<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemRequest;
use Illuminate\Http\Request;

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
            'size' => 'nullable|string', // Validasi input size
        ]);

        $item = Item::findOrFail($request->item_id);

        // Check if requested quantity exceeds available stock
        // Note: Jika stok per ukuran (size) ingin divalidasi spesifik, logic tambahan diperlukan di sini
        if ($request->quantity > $item->stock) {
            return back()
                ->withInput()
                ->with('error', 'Requested quantity cannot exceed available stock (Current stock: ' . $item->stock . ')');
        }

        ItemRequest::create([
            'item_id' => $request->item_id,
            'user_id' => auth()->id(),
            'size' => $request->size, // Simpan data size
            'quantity' => $request->quantity,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('item-requests.index')->with('success', 'Request submitted successfully.');
    }

    public function approve(ItemRequest $itemRequest)
    {
        if ($itemRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        if ($itemRequest->item->stock < $itemRequest->quantity) {
            return back()->with('error', 'Insufficient stock to approve this request.');
        }

        \DB::transaction(function () use ($itemRequest) {
            // Update request status
            $itemRequest->update([
                'status' => 'approved',
                'processed_by' => auth()->id(),
                'processed_at' => now(),
            ]);

            // Create transaction
            $itemRequest->item->transactions()->create([
                'user_id' => $itemRequest->user_id,
                'type' => 'out',
                'quantity' => $itemRequest->quantity,
                'date' => now(),
                'note' => 'Approved request #' . $itemRequest->id,
            ]);

            // Update stock
            $itemRequest->item->decrement('stock', $itemRequest->quantity);
        });

        return redirect()->route('item-requests.index')->with('success', 'Request approved successfully.');
    }
    
    public function show(ItemRequest $itemRequest)
    {
        // Authorization check - only admin or the requester can view
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