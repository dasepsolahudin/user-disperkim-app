<x-app-layout>
    {{-- HEADER HALAMAN --}}
    <x-slot name="header">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                <i class="fas fa-search fa-lg text-blue-600 dark:text-blue-400"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                    Hasil Pencarian untuk: "{{ $query }}"
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Ditemukan {{ $complaints->total() }} hasil yang cocok dengan kata kunci Anda.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if($complaints->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($complaints as $complaint)
                        <a href="{{ route('pengaduan.show', $complaint) }}" class="block p-4 sm:p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 truncate">{{ $complaint->title }}</p>
                                <p class="text-xs text-gray-500">{{ $complaint->created_at->diffForHumans() }}</p>
                            </div>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                {{ $complaint->description }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Navigasi Halaman --}}
            @if ($complaints->hasPages())
                <div class="px-4 py-3">
                    {{ $complaints->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-16">
                <i class="fas fa-box-open fa-3x text-gray-300 dark:text-gray-600"></i>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-200">Tidak Ada Hasil Ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Coba gunakan kata kunci lain yang lebih umum.
                </p>
            </div>
        @endif
    </div>
</x-app-layout>