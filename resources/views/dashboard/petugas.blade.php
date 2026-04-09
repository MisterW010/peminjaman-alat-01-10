<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Petugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-emerald-600 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-white font-bold text-lg">
                    {{ __("Selamat Datang, Petugas Operator!") }}
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Sirkulasi Peminjaman -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-bold mb-2">Tugas Peminjaman & Pengembalian</h3>
                        <p class="text-sm text-gray-500 mb-4">Setujui permohonan pengguna dan pastikan pengembalian alat fisik direcord di sistem.</p>
                        <div class="flex flex-col space-y-2">
                            <a href="{{ route('admin.borrowings.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center transition">Kelola Daftar Permintaan & Pengembalian</a>
                        </div>
                    </div>
                </div>

                <!-- Laporan -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-bold mb-2">Laporan Harian</h3>
                        <p class="text-sm text-gray-500 mb-4">Cetak laporan harian tentang sirkulasi peminjaman alat.</p>
                        <a href="{{ route('admin.borrowings.report') }}" class="block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded w-full text-center transition">Cetak Rekap Sirkulasi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
