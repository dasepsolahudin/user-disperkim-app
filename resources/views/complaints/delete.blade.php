<x-app-layout>
    <div class="max-w-2xl mx-auto space-y-6">

        <!-- Judul -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-2xl font-bold text-red-600">🗑️ Hapus Laporan</h2>
            <p class="mt-2 text-gray-600">
                Apakah Anda yakin ingin menghapus laporan <span class="font-semibold">"{{ $complaint->title }}"</span>?  
                Tindakan ini <span class="text-red-500 font-semibold">tidak bisa dibatalkan</span>.
            </p>
        </div>

        <!-- Detail Singkat -->
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <p><span class="font-semibold text-gray-700">Judul:</span> {{ $complaint->title }}</p>
            <p><span class="font-semibold text-gray-700">Isi Laporan:</span> {{ Str::limit($complaint->description, 100) }}</p>
            <p><span class="font-semibold text-gray-700">Tanggal:</span> {{ $complaint->created_at->format('d M Y, H:i') }}</p>

            @if($complaint->photo)
                <div class="mt-3">
                    <p class="font-semibold text-gray-700 mb-2">Foto:</p>
                    <img src="{{ asset('storage/' . $complaint->photo) }}" 
                         alt="Foto Laporan" 
                         class="w-48 rounded-lg shadow">
                </div>
            @endif
        </div>

        <!-- Tombol Konfirmasi -->
        <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
            <a href="{{ route('complaints.show', $complaint->id) }}" 
               class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-300 transition">
               ⬅️ Batal
            </a>
            
            <form method="POST" action="{{ route('complaints.destroy', $complaint->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 transition">
                    🗑️ Hapus Permanen
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
