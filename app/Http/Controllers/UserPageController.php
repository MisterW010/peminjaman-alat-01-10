<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\Borrowing;
use App\Models\ActivityLog;
use Carbon\Carbon;

class UserPageController extends Controller
{
    // Katalog Alat
    public function catalog()
    {
        $equipment = Equipment::with('category')->where('available_qty', '>', 0)->get();
        return view('user.catalog', compact('equipment'));
    }

    // Proses Peminjaman
    public function storeBorrow(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'expected_return_date' => 'required|date|after_or_equal:today',
        ]);

        $equipment = Equipment::findOrFail($request->equipment_id);

        if ($equipment->available_qty < 1) {
            return back()->with('error', 'Maaf, alat ini sudah terpinjam semuanya.');
        }

        $borrowing = Borrowing::create([
            'user_id' => auth()->id(),
            'equipment_id' => $request->equipment_id,
            'request_date' => Carbon::today(),
            'expected_return_date' => $request->expected_return_date,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Mengajukan Peminjaman',
            'description' => 'Mengajukan peminjaman alat ' . $equipment->name,
        ]);

        return redirect()->route('user.history')->with('success', 'Permohonan peminjaman berhasil diajukan. Menunggu persetujuan petugas.');
    }

    // Riwayat Peminjaman & Form Pengembalian
    public function history()
    {
        $borrowings = Borrowing::with('equipment')
                        ->where('user_id', auth()->id())
                        ->orderBy('created_at', 'desc')
                        ->get();
        return view('user.history', compact('borrowings'));
    }

    // Proses Pengembalian (Update status)
    public function returnBorrow(Borrowing $borrowing)
    {
        // Pastikan hanya peminjamnya yang bisa mengembalikan
        if ($borrowing->user_id !== auth()->id() || $borrowing->status !== 'approved') {
            return back()->with('error', 'Permintaan tidak valid.');
        }

        // We mark it as 'returned'. Wait, ideally Petugas marks 'returned' after physical check.
        // But for this requirement "mengembalikan alat", we will let user change it to returned 
        // to simplify the flow as requested.
        $borrowing->update([
            'status' => 'returned',
            'actual_return_date' => Carbon::now()
        ]);

        // Kembalikan stok
        $borrowing->equipment->increment('available_qty');

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Mengembalikan Alat',
            'description' => 'Mengembalikan alat ' . $borrowing->equipment->name . ' (#' . $borrowing->id . ')',
        ]);

        return redirect()->back()->with('success', 'Alat berhasil dikembalikan. Terima kasih!');
    }
}
