<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-6">

        <!-- Judul -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-2xl font-bold text-gray-800">📌 Detail Pengaduan</h2>
            <p class="mt-2 text-gray-600">Informasi lengkap dari laporan Anda.</p>
        </div>

        <!-- Detail Laporan -->
        <div class="bg-white p-6 rounded-xl shadow space-y-6">
            
            <!-- Judul & Status -->
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-semibold text-gray-800">{{ $complaint->title }}</h3>
                <span class="px-4 py-1 text-sm font-medium rounded-lg 
                    @if($complaint->status == 'completed') bg-green-100 text-green-700 
                    @elseif($complaint->status == 'in_progress') bg-yellow-100 text-yellow-700 
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                </span>
            </div>

            <!-- Deskripsi -->
            <div>
                <h4 class="font-semibold text-gray-700 mb-2">📝 Deskripsi</h4>
                <p class="text-gray-600 leading-relaxed">{{ $complaint->description }}</p>
            </div>

            <!-- Lampiran Foto -->
            @if($complaint->photo)
                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">📷 Foto Lampiran</h4>
                    <img src="{{ asset('storage/' . $complaint->photo) }}" 
                         alt="Foto Laporan" 
                         class="rounded-lg shadow max-h-80">
                </div>
            @endif

            <!-- Info Tambahan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-gray-700 mb-1">📅 Dibuat Pada</h4>
                    <p class="text-gray-600">{{ $complaint->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-700 mb-1">⚡ Terakhir Diperbarui</h4>
                    <p class="text-gray-600">{{ $complaint->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-between items-center pt-4 border-t">
                <a href="{{ route('complaints.index') }}" 
                   class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-300 transition">
                   ⬅️ Kembali
                </a>
                <div class="flex gap-3">
                    <a href="{{ route('complaints.edit', $complaint->id) }}" 
                       class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                       ✏️ Edit
                    </a>
                    <form action="{{ route('complaints.destroy', $complaint->id) }}" method="POST" onsubmit="return confirm('Yakin hapus laporan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 transition">
                            🗑️ Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
