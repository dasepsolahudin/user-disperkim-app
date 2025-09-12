<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pengaduan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Tombol buat pengaduan baru --}}
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('complaints.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md
                                  font-semibold text-xs text-white uppercase tracking-widest
                                  hover:bg-green-700 active:bg-green-900 focus:outline-none
                                  focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25
                                  transition ease-in-out duration-150">
                            Buat Pengaduan Baru
                        </a>
                    </div>

                    {{-- Tabel pengaduan --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Pengaduan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lapor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                {{-- PERULANGAN DIMULAI DI SINI --}}
                                @forelse ($complaints as $complaint)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{-- ✅ Menggunakan $complaint, BUKAN $item --}}
                                            {{ $complaint->title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $complaint->category }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $complaint->created_at->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($complaint->status == 'Baru') bg-blue-100 text-blue-800
                                                @elseif($complaint->status == 'Verifikasi') bg-yellow-100 text-yellow-800
                                                @elseif($complaint->status == 'Pengerjaan') bg-orange-100 text-orange-800
                                                @else bg-green-100 text-green-800 @endif">
                                                {{ $complaint->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <a href="{{ route('complaints.show', $complaint->id) }}"
                                               class="text-blue-600 hover:underline">Detail</a> |
                                            <a href="{{ route('complaints.edit', $complaint->id) }}"
                                               class="text-green-600 hover:underline">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Anda belum membuat pengaduan.
                                        </td>
                                    </tr>
                                @endforelse
                                {{-- PERULANGAN BERAKHIR DI SINI --}}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>