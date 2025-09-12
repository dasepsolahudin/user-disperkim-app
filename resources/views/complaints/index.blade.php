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

                    <div class="flex justify-end mb-6">
                        <a href="{{ route('complaints.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Buat Pengaduan Baru
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Pengaduan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lapor</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($complaints as $complaint)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ Str::limit($complaint->title, 35) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', $complaint->category) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $complaint->created_at->format('d F Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($complaint->status == 'Baru') bg-blue-100 text-blue-800 
                                                @elseif($complaint->status == 'Verifikasi') bg-yellow-100 text-yellow-800
                                                @elseif($complaint->status == 'Pengerjaan') bg-orange-100 text-orange-800
                                                @else bg-green-100 text-green-800 @endif">
                                                {{ $complaint->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('pengaduan.show', $complaint->id) }}" class="px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-md shadow-sm hover:bg-blue-600 transition">
                                                    Detail
                                                </a>
                                                <a href="{{ route('complaints.edit', $complaint->id) }}" class="px-3 py-1 bg-indigo-500 text-white text-xs font-semibold rounded-md shadow-sm hover:bg-indigo-600 transition">
                                                    Edit
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">
                                            Anda belum membuat pengaduan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Link Paginasi --}}
                    <div class="mt-6">
                        {{ $complaints->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

### Langkah 2: Bersihkan Cache (Paling Penting)

Sekarang, buka terminal atau *command prompt* Anda, masuk ke direktori proyek Laravel Anda, dan jalankan perintah berikut:

```bash
php artisan view:clear

