<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 flex flex-col md:flex-row p-6 gap-6">
                <!-- Info Status Aktif -->
                <div class="flex-1 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl p-6 text-white shadow">
                    <h3 class="text-lg font-bold opacity-90 mb-1">Alat Sedang Dipinjam</h3>
                    <p class="text-4xl font-extrabold">{{ $borrowings->where('status', 'approved')->count() }}</p>
                </div>
                <div class="flex-1 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl p-6 text-white shadow">
                    <h3 class="text-lg font-bold opacity-90 mb-1">Menunggu Persetujuan</h3>
                    <p class="text-4xl font-extrabold">{{ $borrowings->where('status', 'pending')->count() }}</p>
                </div>
                <div class="flex-1 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl p-6 text-white shadow">
                    <h3 class="text-lg font-bold opacity-90 mb-1">Selesai Dikembalikan</h3>
                    <p class="text-4xl font-extrabold">{{ $borrowings->where('status', 'returned')->count() }}</p>
                </div>
            </div>

            <!-- Tabel Riwayat -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-bold mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">Daftar Peminjaman Saya</h3>
                    
                    <div class="overflow-x-auto w-full">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Perangkat (Alat)</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Tgl Mengajukan</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Target Kembali</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse($borrowings as $borrow)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $borrow->equipment->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $borrow->request_date->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $borrow->expected_return_date->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($borrow->status == 'pending')
                                            <span class="px-2 py-1 text-xs font-bold rounded bg-yellow-100 text-yellow-800">Menunggu</span>
                                        @elseif($borrow->status == 'approved')
                                            <span class="px-2 py-1 text-xs font-bold rounded bg-blue-100 text-blue-800">Aktif Dipinjam</span>
                                        @elseif($borrow->status == 'returned')
                                            <span class="px-2 py-1 text-xs font-bold rounded bg-green-100 text-green-800">Selesai</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-bold rounded bg-red-100 text-red-800">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if($borrow->status === 'approved')
                                            <form action="{{ route('user.borrow.return', $borrow) }}" method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded shadow text-xs font-bold transition-transform transform hover:scale-105" onclick="return confirm('Apakah Anda yakin ingin mengembalikan alat ini sekarang?')">KEMBALIKAN SEKARRANG</button>
                                            </form>
                                        @elseif($borrow->status === 'pending')
                                            <span class="text-gray-400 italic text-xs">Aksi diblokir</span>
                                        @else
                                            <span class="text-green-600 font-bold text-xs">✓ Done</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Anda belum pernah meminjam alat apapun.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
