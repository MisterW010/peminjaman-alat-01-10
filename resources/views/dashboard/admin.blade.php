<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Administrator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-indigo-600 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-white font-bold text-lg">
                    {{ __("Selamat Datang di Halaman Admin Utama!") }}
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Data Master -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-bold mb-2">Master Data</h3>
                        <ul class="list-disc pl-5 space-y-2">
                            <li><a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:underline">Kelola Pengguna (User)</a></li>
                            <li><a href="{{ route('admin.categories.index') }}" class="text-indigo-600 hover:underline">Kelola Kategori Alat</a></li>
                            <li><a href="{{ route('admin.equipment.index') }}" class="text-indigo-600 hover:underline">Kelola Inventaris Alat</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Transaksi -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-bold mb-2">Sirkulasi</h3>
                        <ul class="list-disc pl-5 space-y-2">
                            <li><a href="{{ route('admin.borrowings.index') }}" class="text-indigo-600 hover:underline">Daftar Peminjaman & Pengembalian</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Laporan & Log -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-bold mb-2">Laporan</h3>
                        <ul class="list-disc pl-5">
                            <li>Cetak Laporan Sirkulasi</li>
                            <li>Lihat Log Aktifitas Sistem</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
