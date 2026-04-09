<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'equipment'])->latest()->get();
        return view('admin.borrowings.index', compact('borrowings'));
    }

    // Usually admin uses edit/update to change status (approve, reject, returned)
    public function edit(Borrowing $borrowing)
    {
        return view('admin.borrowings.edit', compact('borrowing'));
    }

    public function update(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,returned',
            'notes' => 'nullable|string'
        ]);

        // Logic to adjust equipment available quantity based on status changes
        if ($request->status === 'approved' && $borrowing->status === 'pending') {
            $borrowing->equipment->decrement('available_qty');
        } elseif ($request->status === 'returned' && $borrowing->status === 'approved') {
            $borrowing->equipment->increment('available_qty');
            $borrowing->actual_return_date = Carbon::now();
        }

        $borrowing->update([
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Update Status Peminjaman',
            'description' => 'Mengubah status permohonan #' . $borrowing->id . ' menjadi ' . $request->status,
        ]);

        return redirect()->route('admin.borrowings.index')->with('success', 'Status peminjaman berhasil diperbarui.');
    }
    
    public function report()
    {
        // Fetch all borrowings or filter by returned status. For pure sirkulasi report, all history helps.
        $borrowings = Borrowing::with(['user', 'equipment'])->orderBy('created_at', 'desc')->get();
        return view('admin.borrowings.report', compact('borrowings'));
    }

    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();
        return redirect()->route('admin.borrowings.index')->with('success', 'Data peminjaman dihapus.');
    }
}
