<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemRequest;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function stockReport()
    {
        $items = Item::with(['category', 'unit'])->get();
        return view('reports.stock', compact('items'));
    }

    public function downloadStockReport()
    {
        $items = Item::with(['category', 'unit'])->get();
        $pdf = Pdf::loadView('reports.pdf.stock', compact('items'));
        return $pdf->download('stock-report.pdf');
    }

    public function transactionReport(Request $request)
    {
        $transactions = Transaction::with(['item', 'user'])
            ->when($request->date_from, function ($query) use ($request) {
                $query->where('date', '>=', $request->date_from);
            })
            ->when($request->date_to, function ($query) use ($request) {
                $query->where('date', '<=', $request->date_to);
            })
            ->latest()
            ->paginate(10);

        return view('reports.transaction', compact('transactions'));
    }

    public function downloadTransactionReport(Request $request)
    {
        $transactions = Transaction::with(['item', 'user'])
            ->when($request->date_from, function ($query) use ($request) {
                $query->where('date', '>=', $request->date_from);
            })
            ->when($request->date_to, function ($query) use ($request) {
                $query->where('date', '<=', $request->date_to);
            })
            ->latest()
            ->get();

        $pdf = Pdf::loadView('reports.pdf.transaction', compact('transactions'));
        return $pdf->download('transaction-report.pdf');
    }

    public function requestReport(Request $request)
    {
        $requests = ItemRequest::with(['item', 'user', 'processedBy'])
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->date_from, function ($query) use ($request) {
                $query->where('created_at', '>=', $request->date_from);
            })
            ->when($request->date_to, function ($query) use ($request) {
                $query->where('created_at', '<=', $request->date_to);
            })
            ->latest()
            ->paginate(10);

        return view('reports.request', compact('requests'));
    }

    public function downloadRequestReport(Request $request)
    {
        $requests = ItemRequest::with(['item', 'user', 'processedBy'])
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->date_from, function ($query) use ($request) {
                $query->where('created_at', '>=', $request->date_from);
            })
            ->when($request->date_to, function ($query) use ($request) {
                $query->where('created_at', '<=', $request->date_to);
            })
            ->latest()
            ->get();

        $pdf = Pdf::loadView('reports.pdf.request', compact('requests'));
        return $pdf->download('request-report.pdf');
    }
}