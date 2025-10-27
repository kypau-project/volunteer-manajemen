<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-xl font-semibold mb-4">{{ $event->exists ? 'Edit' : 'Buat' }} Acara</h3>

                <form wire:submit.prevent="save">
                    <!-- Title -->
                    <div class="mt-4">
                        <label for="title" class="block font-medium text-sm text-gray-700">Judul Acara</label>
                        <input wire:model="title" id="title" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required autofocus />
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Description -->
                    <div class="mt-4">
                        <label for="description" class="block font-medium text-sm text-gray-700">Deskripsi</label>
                        <textarea wire:model="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Category -->
                    <div class="mt-4">
                        <label for="category" class="block font-medium text-sm text-gray-700">Kategori</label>
                        <input wire:model="category" id="category" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        @error('category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Start Date -->
                        <div class="mt-4">
                            <label for="start_date" class="block font-medium text-sm text-gray-700">Tanggal & Waktu Mulai</label>
                            <input wire:model="start_date" id="start_date" type="datetime-local" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                            @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- End Date -->
                        <div class="mt-4">
                            <label for="end_date" class="block font-medium text-sm text-gray-700">Tanggal & Waktu Selesai</label>
                            <input wire:model="end_date" id="end_date" type="datetime-local" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                            @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="mt-4">
                        <label for="location" class="block font-medium text-sm text-gray-700">Lokasi</label>
                        <input wire:model="location" id="location" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                        @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Quota -->
                        <div class="mt-4">
                            <label for="quota" class="block font-medium text-sm text-gray-700">Kuota Relawan</label>
                            <input wire:model="quota" id="quota" type="number" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                            @error('quota') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <label for="status" class="block font-medium text-sm text-gray-700">Status Acara</label>
                            <select wire:model="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Required Skills -->
                    <div class="mt-4">
                        <label for="required_skills" class="block font-medium text-sm text-gray-700">Kebutuhan Keterampilan (Pisahkan dengan koma)</label>
                        <input wire:model="required_skills" id="required_skills" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Contoh: Public Speaking, Fotografi, Medis" />
                        @error('required_skills') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        {{-- Placeholder route --}}
                        <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out">
                            Simpan Acara
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
