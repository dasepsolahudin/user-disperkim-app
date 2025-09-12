<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                {{-- Tombol Kamera --}}
<form id="photo-form" action="{{ route('profile.updatePhoto') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="photo"
           class="absolute bottom-0 right-0 bg-indigo-600 text-white p-2 rounded-full shadow cursor-pointer hover:bg-indigo-700">
        <svg xmlns="http://www.w3.org/2000/svg"
             fill="none" viewBox="0 0 24 24" stroke="currentColor"
             class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 7h2l2-3h10l2 3h2a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V8a1 1 0 011-1z" />
            <circle cx="12" cy="13" r="3" stroke="currentColor" stroke-width="2"/>
        </svg>
    </label>
    <input id="photo" type="file" name="photo" class="hidden"
           accept="image/*" capture="user"
           onchange="uploadPhoto(this)">
</form>

<script>
function uploadPhoto(input) {
    if (input.files && input.files[0]) {
        let formData = new FormData(document.getElementById('photo-form'));

        fetch("{{ route('profile.updatePhoto') }}", {
            method: "POST",
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                document.getElementById('preview-photo').src = data.photo_url;
            }
        })
        .catch(err => console.error(err));
    }
}
</script>


                    <form method="POST" action="{{ route('complaints.update', $complaint->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- method untuk update --}}

                        {{-- Judul Pengaduan --}}
                        <div>
                            <x-input-label for="title" :value="__('Judul Pengaduan')" />
                            <x-text-input 
                                id="title" 
                                class="block mt-1 w-full" 
                                type="text" 
                                name="title" 
                                :value="old('title', $complaint->title)" 
                                required 
                                autofocus 
                            />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsikan Pengaduan Anda')" />
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="5" 
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            >{{ old('description', $complaint->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Lokasi Spesifik --}}
                        <div class="mt-4">
                            <x-input-label for="location_text" :value="__('Lokasi Spesifik Aduan')" />
                            <textarea 
                                id="location_text" 
                                name="location_text" 
                                rows="3" 
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            >{{ old('location_text', $complaint->location_text) }}</textarea>
                            <x-input-error :messages="$errors->get('location_text')" class="mt-2" />
                        </div>

                        <hr class="my-6">

                        {{-- Foto Lampiran --}}
                        <div>
                            <x-input-label for="photos" :value="__('Ganti Foto Aduan (Opsional)')" />
                            <p class="text-sm text-gray-500 mb-2">
                                Jika Anda mengunggah foto baru, semua foto lama akan diganti.
                            </p>
                            <input 
                                type="file" 
                                id="photos" 
                                name="photos[]" 
                                class="block w-full text-sm text-gray-500 
                                    file:mr-4 file:py-2 file:px-4 
                                    file:rounded-md file:border-0 
                                    file:text-sm file:font-semibold 
                                    file:bg-green-100 file:text-green-700 
                                    hover:file:bg-green-200 mt-1"
                                accept="image/*"
                                multiple
                            />
                            <x-input-error :messages="$errors->get('photos.*')" class="mt-2" />
                        </div>

                        {{-- Foto Saat Ini --}}
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-700">Foto Saat Ini:</p>
                            <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                                @forelse ($complaint->photos as $photo)
                                    <img 
                                        src="{{ asset('storage/' . $photo->path) }}" 
                                        alt="Foto Aduan" 
                                        class="rounded-lg object-cover h-28 w-full"
                                    >
                                @empty
                                    <p class="text-gray-500 col-span-full">Tidak ada foto.</p>
                                @endforelse
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center justify-between mt-8 border-t pt-6">
                            <a href="{{ route('complaints.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-black text-white text-sm font-medium rounded-md hover:bg-gray-800 transition">
            Batal
        </a>
                            <button type="submit" 
                class="inline-flex items-center px-4 py-2 bg-black text-white text-sm font-medium rounded-md hover:bg-gray-800 transition">
            Simpan Perubahan
        </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
