<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Penyelesaian Sirkulasi / Persetujuan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col md:flex-row gap-8">
                    
                    <!-- Sisi Informasi -->
                    <div class="flex-1">
                        <h3 class="text-xl font-bold border-b pb-2 mb-4">Informasi Permintaan</h3>
                        
                        <div class="mb-3">
                            <span class="block text-sm text-gray-500">Oleh Peminjam:</span>
                            <span class="font-semibold text-lg">{{ $borrowing->user->name }} ({{ $borrowing->user->email }})</span>
                        </div>
                        
                        <div class="mb-3">
                            <span class="block text-sm text-gray-500">Barang/Alat:</span>
                            <span class="font-semibold text-lg text-indigo-600 dark:text-indigo-400">{{ $borrowing->equipment->name }}</span>
                        </div>
                        
                        <div class="mb-3 flex justify-between bg-gray-50 dark:bg-gray-700 p-3 rounded">
                            <div>
                                <span class="block text-xs text-gray-500">Dijadwalkan Pinjam</span>
                                <span class="font-medium">{{ $borrowing->request_date->format('d M Y') }}</span>
                            </div>
                            <div class="text-right">
                                <span class="block text-xs text-gray-500">Target Batas Waktu</span>
                                <span class="font-medium text-red-600">{{ $borrowing->expected_return_date->format('d M Y') }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <span class="block text-sm text-gray-500">Catatan Peminjam:</span>
                            <div class="bg-yellow-50 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 p-3 rounded italic text-sm">
                                "{{ $borrowing->notes ?? 'Tidak ada catatan khusus.' }}"
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <span class="block text-sm text-gray-500">Status Saat Ini:</span>
                            <span class="px-3 py-1 font-bold rounded-full text-sm uppercase bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white">
                                {{ $borrowing->status }}
                            </span>
                        </div>
                    </div>

                    <!-- Sisi Intervensi Admin/Petugas -->
                    <div class="flex-1 bg-gray-50 dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                        <h3 class="text-lg font-bold mb-4">Ubah Status</h3>
                        
                        <form action="{{ route('admin.borrowings.update', $borrowing) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tindakan Keputusan</label>
                                <select name="status" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 shadow-sm focus:border-indigo-500">
                                    <option value="pending" {{ $borrowing->status == 'pending' ? 'selected' : '' }}>Pending (Tunda)</option>
                                    <option value="approved" {{ $borrowing->status == 'approved' ? 'selected' : '' }}>Setujui (Dipinjamkan)</option>
                                    <option value="returned" {{ $borrowing->status == 'returned' ? 'selected' : '' }}>Menerima Pengembalian</option>
                                    <option value="rejected" {{ $borrowing->status == 'rejected' ? 'selected' : '' }}>Tolak Permintaan</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Mengubah menjadi "Setujui" akan otomatis memotong stok alat.</p>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tambahkan Catatan Petugas (Opsional)</label>
                                <textarea name="notes" rows="3" placeholder="Misal: Ditolak karena stok terbatas, atau kondisi alat saat kembali cacat..." class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 shadow-sm focus:border-indigo-500">{{ old('notes', $borrowing->notes) }}</textarea>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded shadow transition-transform transform hover:-translate-y-1">Simpan Perubahan</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
