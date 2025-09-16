<x-app-layout>
    <x-slot name="header">
        {{-- Header dengan tambahan tombol kembali --}}
        <div class="flex items-center space-x-4">
            <a href="{{ url()->previous() }}" class="p-2 rounded-md text-slate-500 hover:bg-slate-100 dark:text-gray-400 dark:hover:bg-gray-900 focus:outline-none">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Hasil Pencarian') }}
            </h2>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
            Menampilkan hasil untuk: "<span class="font-bold">{{ $query }}</span>"
        </h3>

        @if($complaints->count() > 0)
            <div class="space-y-4">
                @foreach ($complaints as $complaint)
                    <div class="p-4 border dark:border-gray-700 rounded-lg">
                        <a href="{{ route('pengaduan.show', $complaint->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                            <h4 class="font-bold text-md">{{ $complaint->title }}</h4>
                        </a>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            {{ Str::limit($complaint->description, 150) }}
                        </p>
                        <p class="text-xs text-gray-500 mt-2">
                            Dilaporkan pada: {{ $complaint->created_at->format('d M Y') }}
                        </p>
                    </div>
                @endforeach
            </div>

            {{-- Link Paginasi yang sudah diperbaiki --}}
            <div class="mt-6">
                {{ $complaints->appends(['q' => $query])->links() }}
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400">Tidak ada hasil yang ditemukan.</p>
        @endif
    </div>
</x-app-layout>