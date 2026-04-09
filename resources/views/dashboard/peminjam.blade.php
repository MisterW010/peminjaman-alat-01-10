<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Peminjam') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-orange-500 to-red-500 overflow-hidden shadow-lg sm:rounded-lg mb-8">
                <div class="p-8 text-white">
                    <h3 class="font-bold text-2xl mb-2">{{ __("Selamat Datang!") }}</h3>
                    <p class="text-orange-100">{{ __("Pinjam perlengkapan yang Anda butuhkan dengan cepat dan mudah.") }}</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Pintasan Katalog -->
                <a href="{{ route('user.catalog') }}" class="group block bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 dark:border-gray-700 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-orange-100 dark:bg-gray-700 opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-orange-100 text-orange-600 dark:bg-gray-700 dark:text-orange-400 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-2 text-gray-800 dark:text-white">Katalog Alat Tersedia</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">Jelajahi berbagai macam alat yang tersedia di inventaris kami untuk mendukung kegiatan Anda.</p>
                        <span class="inline-flex items-center text-orange-600 font-bold group-hover:underline">
                            Mulai Meminjam 
                            <svg class="ml-2 w-4 h-4 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                    </div>
                </a>

                <!-- Pintasan Riwayat -->
                <a href="{{ route('user.history') }}" class="group block bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 dark:border-gray-700 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-indigo-100 dark:bg-gray-700 opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-indigo-100 text-indigo-600 dark:bg-gray-700 dark:text-indigo-400 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-2 text-gray-800 dark:text-white">Alat Dipinjam & Riwayat</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">Pantau status pengajuan peminjaman Anda, kelola barang yang sedang dipinjam, dan proses pengembalian.</p>
                        <span class="inline-flex items-center text-indigo-600 font-bold group-hover:underline">
                            Cek Status Anda 
                            <svg class="ml-2 w-4 h-4 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
