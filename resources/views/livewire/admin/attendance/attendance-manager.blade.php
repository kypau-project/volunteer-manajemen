<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __("Manajemen Kehadiran: " . $event->title) }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                @if (session()->has("message"))
                    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700" role="alert">
                        <p>{{ session("message") }}</p>
                    </div>
                @endif
                @if (session()->has("error"))
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700" role="alert">
                        <p>{{ session("error") }}</p>
                    </div>
                @endif
                
                <div class="mb-6 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="w-full md:w-1/2">
                        <input wire:model.lazy="search" type="text" placeholder="Cari relawan..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <div class="w-full md:w-1/4">
                        <select wire:model.lazy="statusFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                        </select>
                    </div>
                </div>

                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Relawan</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status Pendaftaran</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Check In</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Check Out</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($registrations as $registration)
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ $registration->user->name }}</p>
                                            <p class="text-gray-600 whitespace-no-wrap text-xs">{{ $registration->user->email }}</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <span class="relative inline-block px-3 py-1 font-semibold leading-tight 
                                                @if($registration->status == 'approved') text-green-900 @else text-yellow-900 @endif">
                                                <span aria-hidden class="absolute inset-0 
                                                    @if($registration->status == 'approved') bg-green-200 @else bg-yellow-200 @endif 
                                                    opacity-50 rounded-full"></span>
                                                <span class="relative">{{ ucfirst($registration->status) }}</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{ $registration->check_in ? $registration->check_in->format("H:i:s, d M") : "-" }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{ $registration->check_out ? $registration->check_out->format("H:i:s, d M") : "-" }}
                                                @if($registration->hours_contributed > 0)
                                                    <span class="text-xs text-indigo-600">({{ number_format($registration->hours_contributed, 2) }} jam)</span>
                                                @endif
                                            </p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            @if(!$registration->check_in)
                                                <button wire:click="checkIn({{ $registration->id }})" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-2 rounded-md text-xs">
                                                    Check In
                                                </button>
                                            @elseif(!$registration->check_out)
                                                <button wire:click="checkOut({{ $registration->id }})" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded-md text-xs mb-1">
                                                    Check Out
                                                </button>
                                                @if($registration->attended && $registration->check_out)
                                                    @if($registration->certificate_id)
                                                        <a href="{{ route('admin.certificates.download', $registration) }}" target="_blank" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-1 px-2 rounded-md text-xs">
                                                            Download Sertifikat
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.certificates.generate', $registration) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded-md text-xs">
                                                            Buat Sertifikat
                                                        </a>
                                                    @endif
                                                @endif
                                            @else
                                                <span class="text-sm text-gray-500">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                            Tidak ada relawan yang terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                            {{ $registrations->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
