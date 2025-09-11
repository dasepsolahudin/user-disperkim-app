<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-6">

        <!-- Judul -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-2xl font-bold text-gray-800">✏️ Edit Laporan</h2>
            <p class="mt-2 text-gray-600">Perbarui informasi laporan Anda di bawah ini.</p>
        </div>

        <!-- Form Edit -->
        <div class="bg-white p-6 rounded-xl shadow">
            <form method="POST" action="{{ route('complaints.update', $complaint->id) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Judul Laporan -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700">Judul Laporan</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $complaint->title) }}"
                           class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('title')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Isi Laporan -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700">Isi Laporan</label>
                    <textarea name="description" id="description" rows="5"
                              class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description', $complaint->description) }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto Lampiran -->
                <div>
                    <label for="photo" class="block text-sm font-semibold text-gray-700">Foto Lampiran</label>
                    <input type="file" name="photo" id="photo" class="mt-2 block w-full text-sm text-gray-700">
                    @if($complaint->photo)
                        <div class="mt-3">
                            <p class="text-sm text-gray-500 mb-2">Foto saat ini:</p>
                            <img src="{{ asset('storage/' . $complaint->photo) }}" alt="Foto Laporan" class="w-40 rounded-lg shadow">
                        </div>
                    @endif
                    @error('photo')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-between items-center pt-4 border-t">
                    <a href="{{ route('complaints.index') }}" 
                       class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-300 transition">
                       ⬅️ Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                        💾 Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
