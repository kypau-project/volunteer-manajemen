<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __("Dashboard Relawan") }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <h3 class="text-lg font-medium text-gray-900">Total Jam Kontribusi</h3>
                <p class="mt-1 text-3xl font-semibold text-indigo-600">{{ number_format($totalHours, 2) }} Jam</p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <h3 class="text-lg font-medium text-gray-900">Acara Diikuti</h3>
                <p class="mt-1 text-3xl font-semibold text-indigo-600">{{ $registrations->total() }}</p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <h3 class="text-lg font-medium text-gray-900">Acara Mendatang</h3>
                <p class="mt-1 text-3xl font-semibold text-indigo-600">{{ $registrations->where("event.start_date", ">", now())->count() }}</p>
            </div>
        </div>

        <!-- Participation History -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-xl font-semibold mb-4">Riwayat Partisipasi Acara</h3>
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Acara</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status Pendaftaran</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($registrations as $registration)
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ $registration->event->title }}</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ $registration->event->start_date->format('d M Y') }}</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <span class="relative inline-block px-3 py-1 font-semibold leading-tight 
                                                @if($registration->status == 'approved') text-green-900 @elseif($registration->status == 'pending') text-yellow-900 @else text-red-900 @endif">
                                                <span aria-hidden class="absolute inset-0 
                                                    @if($registration->status == 'approved') bg-green-200 @elseif($registration->status == 'pending') bg-yellow-200 @else bg-red-200 @endif 
                                                    opacity-50 rounded-full"></span>
                                                <span class="relative">{{ ucfirst($registration->status) }}</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <span class="text-gray-900 whitespace-no-wrap">{{ $registration->attended ? 'Hadir' : 'Belum Hadir' }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                            Anda belum pernah mendaftar di acara manapun.
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

