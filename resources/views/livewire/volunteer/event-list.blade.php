<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __("Daftar Acara Tersedia") }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                
                <!-- Flash Messages -->
                @if (session()->has('message'))
                    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700" role="alert">
                        <p>{{ session('message') }}</p>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Filters -->
                <div class="mb-6 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="w-full md:w-1/2">
                        <input wire:model.lazy="search" type="text" placeholder="Cari berdasarkan judul atau lokasi..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <div class="w-full md:w-1/4">
                        <select wire:model.lazy="categoryFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Event Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($events as $event)
                        <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden flex flex-col justify-between">
                            <div class="p-6">
                                <h3 class="font-bold text-lg mb-2">{{ $event->title }}</h3>
                                <p class="text-sm text-gray-600 mb-1"><span class="font-semibold">Lokasi:</span> {{ $event->location }}</p>
                                <p class="text-sm text-gray-600 mb-1"><span class="font-semibold">Tanggal:</span> {{ $event->start_date->format('d M Y') }}</p>
                                <p class="text-sm text-gray-600 mb-3"><span class="font-semibold">Waktu:</span> {{ $event->start_date->format('H:i') }} - {{ $event->end_date->format('H:i') }}</p>
                                <p class="text-sm text-gray-700 mb-4">{{ Str::limit($event->description, 100) }}</p>
                                <div class="text-xs text-gray-500">
                                    <p>Kuota: {{ $event->registrations->whereIn('status', ['approved', 'pending'])->count() }} / {{ $event->quota }}</p>
                                </div>
                            </div>
                            <div class="bg-gray-100 p-4 flex justify-end items-center">
                                @if(in_array($event->id, $registeredEventIds))
                                    <span class="text-sm font-semibold text-green-600">Terdaftar</span>
                                @else
                                    <button wire:click="register({{ $event->id }})" wire:loading.attr="disabled" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md text-sm transition duration-150 ease-in-out">
                                        Daftar Sekarang
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-500 py-10">
                            <p>Tidak ada acara yang tersedia saat ini.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
