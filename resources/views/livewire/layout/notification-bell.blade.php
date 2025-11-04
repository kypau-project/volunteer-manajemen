<div class="relative" x-data="{ open: false }" @click.away="open = false">
    <button @click="open = ! open" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.331 8.967 8.967 0 0 1-2.321-3.422c1.286-.51 2.56-1.11 3.794-1.815a1.08 1.08 0 0 0 .288-.376c.07-.152.105-.312.105-.472V7.5a4.5 4.5 0 0 0-9 0v.75a.75.75 0 0 1-1.5 0V7.5a6 6 0 1 1 12 0v2.25c0 .248-.035.49-.105.722a1.08 1.08 0 0 1-.288.376c-1.234.705-2.508 1.305-3.794 1.815a8.967 8.967 0 0 1-2.321 3.422 23.848 23.848 0 0 0 5.454 1.331M10.5 21a2.25 2.25 0 0 0 4.5 0M12 3a3 3 0 0 0-3 3v.75a.75.75 0 0 1-1.5 0V6a4.5 4.5 0 1 1 9 0v.75a.75.75 0 0 1-1.5 0V6a3 3 0 0 0-3-3Z" />
        </svg>
        @if ($unreadCount > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ $unreadCount }}</span>
        @endif
    </button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute z-50 mt-2 w-80 rounded-md shadow-lg origin-top-right right-0"
         style="display: none;">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
            <div class="px-4 py-2 text-xs text-gray-400 border-b">
                Notifikasi ({{ $unreadCount }} Belum Dibaca)
            </div>
            @forelse ($notifications as $notification)
                <a href="#" wire:click.prevent="markAsRead('{{ $notification->id }}')" class="block px-4 py-3 text-sm hover:bg-gray-100 transition duration-150 ease-in-out 
                    @if ($notification->read_at == null) bg-indigo-50 @endif">
                    <p class="font-semibold text-gray-800">{{ $notification->data['title'] ?? 'Notifikasi Baru' }}</p>
                    <p class="text-xs text-gray-600">{{ $notification->data['body'] ?? '' }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </a>
            @empty
                <div class="px-4 py-3 text-sm text-gray-500">
                    Tidak ada notifikasi baru.
                </div>
            @endforelse
            @if ($notifications->count() > 0)
                <div class="px-4 py-2 text-xs text-gray-400 border-t">
                    <button wire:click.prevent="markAllAsRead" class="text-indigo-600 hover:text-indigo-900">Tandai Semua Sudah Dibaca</button>
                </div>
            @endif
        </div>
    </div>
</div>

