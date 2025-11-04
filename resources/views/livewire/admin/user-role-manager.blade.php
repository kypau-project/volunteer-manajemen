<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __("Manajemen Peran Pengguna") }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-xl font-semibold mb-4">Daftar Pengguna</h3>

                @if (session()->has("message"))
                    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700" role="alert">
                        <p>{{ session("message") }}</p>
                    </div>
                @endif

                <div class="flex justify-between mb-4">
                    <input wire:model.live="search" type="text" placeholder="Cari nama atau email..." class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <select wire:model.live="roleFilter" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Semua Peran</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peran</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ $user->name }}</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ $user->email }}</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <span class="relative inline-block px-3 py-1 font-semibold leading-tight 
                                                @if($user->role == "admin") text-red-900 @elseif($user->role == "coordinator") text-yellow-900 @else text-green-900 @endif">
                                                <span aria-hidden class="absolute inset-0 
                                                    @if($user->role == "admin") bg-red-200 @elseif($user->role == "coordinator") bg-yellow-200 @else bg-green-200 @endif 
                                                    opacity-50 rounded-full"></span>
                                                <span class="relative">{{ ucfirst($user->role) }}</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                            <button wire:click="openRoleModal({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                                Ubah Peran
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                            Tidak ada pengguna ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Role Change -->
<x-modal name="change-role" :show="$selectedUserId !== null" focusable>
    <form wire:submit.prevent="saveRole" class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
            Ubah Peran Pengguna
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Pilih peran baru untuk pengguna ini.
        </p>

        <div class="mt-6">
            <label for="newRole" class="block font-medium text-sm text-gray-700">Peran Baru</label>
            <select wire:model="newRole" id="newRole" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">-- Pilih Peran --</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                @endforeach
            </select>
            @error("newRole") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch("close")">
                Batal
            </x-secondary-button>

            <x-primary-button class="ms-3">
                Simpan Peran
            </x-primary-button>
        </div>
    </form>
</x-modal>
