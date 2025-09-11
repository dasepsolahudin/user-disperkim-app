<x-app-layout>
    <div class="space-y-6">

        <!-- Judul -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-2xl font-bold text-gray-800">📑 Riwayat Pengaduan</h2>
            <p class="mt-2 text-gray-600">Daftar laporan yang sudah Anda buat.</p>
        </div>

        <!-- Tabel -->
        <div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="px-4 py-3 rounded-tl-lg">Judul</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3 rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $complaint)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $complaint->title }}</td>
                            <td class="px-4 py-3">
                                @if($complaint->status == 'completed')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-sm rounded-lg">Selesai</span>
                                @elseif($complaint->status == 'in_progress')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-sm rounded-lg">Diproses</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-lg">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $complaint->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('complaints.show', $complaint->id) }}" 
                                   class="text-blue-600 hover:underline">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
