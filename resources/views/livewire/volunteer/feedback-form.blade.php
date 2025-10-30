<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __("Form Feedback Acara") }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-xl font-semibold mb-4">Feedback untuk Acara: {{ $registration->event->title }}</h3>

                <form wire:submit.prevent="saveFeedback">
                    <!-- Rating -->
                    <div class="mt-4">
                        <label for="rating" class="block font-medium text-sm text-gray-700">Penilaian (1-5)</label>
                        <select wire:model="rating" id="rating" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="5">5 - Sangat Baik</option>
                            <option value="4">4 - Baik</option>
                            <option value="3">3 - Cukup</option>
                            <option value="2">2 - Kurang</option>
                            <option value="1">1 - Buruk</option>
                        </select>
                        @error("rating") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Comment -->
                    <div class="mt-4">
                        <label for="comment" class="block font-medium text-sm text-gray-700">Komentar/Saran</label>
                        <textarea wire:model="comment" id="comment" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                        @error("comment") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route("volunteer.dashboard") }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out">
                            Kirim Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
