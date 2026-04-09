<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Katalog Penawaran Alat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white border-b pb-2">Pilih Alat untuk Dipinjam</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($equipment as $item)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-5 shadow-sm border border-gray-200 dark:border-gray-600 flex flex-col hover:shadow-md transition">
                            <div class="w-full h-32 bg-gray-200 dark:bg-gray-600 rounded-lg mb-4 flex items-center justify-center overflow-hidden">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="object-cover h-full w-full">
                                @else
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                @endif
                            </div>
                            <h4 class="font-bold text-lg mb-1 text-gray-900 dark:text-gray-100">{{ $item->name }}</h4>
                            <p class="text-xs text-indigo-600 dark:text-indigo-400 mb-2">{{ $item->category->name }}</p>
                            <p class="text-sm text-gray-500 mb-4 flex-1">{{ Str::limit($item->description, 60) }}</p>
                            
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Tersedia:</span>
                                <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded-full">{{ $item->available_qty }} Unit</span>
                            </div>
                            
                            <!-- Form Peminjaman Triggered here (Simulated using direct form) -->
                            <form action="{{ route('user.borrow.store') }}" method="POST" class="mt-auto">
                                @csrf
                                <input type="hidden" name="equipment_id" value="{{ $item->id }}">
                                
                                <div class="mb-3">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Tgl Pengembalian:</label>
                                    <input type="date" name="expected_return_date" required class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="notes" placeholder="Keperluan pinjam..." class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm shadow-sm py-1 px-2 focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white w-full py-2 rounded-lg text-sm font-bold transition-colors">Ajukan Peminjaman</button>
                            </form>
                        </div>
                    @empty
                        <div class="col-span-full py-10 text-center text-gray-500">
                            Belum ada satupun alat yang sedang tersedia untuk dipinjam saat ini.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
