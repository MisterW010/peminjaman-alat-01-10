<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('user.chatbot');
    }

    public function respond(Request $request)
    {
        $message = strtolower($request->input('message', ''));
        
        $response = "";

        // Logika Rule-Based Sederhana
        if (str_contains($message, 'halo') || str_contains($message, 'hai') || str_contains($message, 'bantuan')) {
            $response = "Halo! Saya Asisten Gudang virtual Anda. Anda dapat menanyakan tentang persediaan alat, misalnya: 'apa saja alat yang tersedia?' atau 'apakah proyektor ada?'";
        } elseif (str_contains($message, 'semua') || str_contains($message, 'apa saja') || str_contains($message, 'daftar')) {
            $equipments = Equipment::where('available_qty', '>', 0)->get();
            if ($equipments->count() > 0) {
                $response = "Saat ini kami memiliki beberapa alat yang siap dipinjam:" . "<br><div class='flex flex-col gap-2 mt-2'>";
                foreach ($equipments as $eq) {
                    $imgParts = $eq->image ? "<img src='".asset('storage/'.$eq->image)."' class='h-12 w-12 object-cover rounded shadow'>" : "<div class='h-12 w-12 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center text-xs text-gray-500'>-</div>";
                    $response .= "<div class='flex items-center gap-3'>" . $imgParts . "<div><b class='text-sm'>" . $eq->name . "</b><br><span class='text-xs text-gray-500'>Tersedia: " . $eq->available_qty . " Unit</span></div></div>";
                }
                $response .= "</div>";
            } else {
                $response = "Maaf, saat ini semua alat sedang dipinjam atau stok kosong.";
            }
        } else {
            // Pencarian spesifik nama barang
            $words = explode(" ", $message);
            $found_equipments = collect();

            foreach ($words as $word) {
                if (strlen($word) > 2) { // Hindari kata terlalu pendek
                    $results = Equipment::where('name', 'LIKE', "%{$word}%")->get();
                    $found_equipments = $found_equipments->merge($results);
                }
            }

            $found_equipments = $found_equipments->unique('id');

            if ($found_equipments->count() > 0) {
                $response = "Ini informasi alat yang Anda cari:<br>";
                foreach ($found_equipments as $eq) {
                    $img = $eq->image ? "<img src='".asset('storage/'.$eq->image)."' class='w-full max-w-xs h-32 object-cover rounded shadow-sm mt-2 mb-2'>" : "";
                    
                    $response .= "<div class='mt-3 bg-indigo-50 dark:bg-gray-800 p-3 rounded-lg border border-indigo-100 dark:border-gray-700'>";
                    $response .= "<b>📦 " . $eq->name . "</b><br>";
                    $response .= $img;
                    $response .= "<span class='text-sm'><b>Tersedia:</b> " . $eq->available_qty . " dari " . $eq->total_qty . " Unit total.</span><br>";
                    $response .= "<span class='text-sm'><b>Kondisi/Ket:</b> " . ($eq->description ?? 'Tidak ada catatan khusus') . "</span>";
                    $response .= "</div>";
                }
            } else {
                $response = "Maaf, saya tidak mengerti maksud Anda atau alat yang Anda sebutkan tidak ditemukan di inventaris. Coba ketikkan nama spesifik alatnya (Cth: Kamera, Kulkas, LCD).";
            }
        }

        return response()->json([
            'reply' => nl2br($response)
        ]);
    }
}
