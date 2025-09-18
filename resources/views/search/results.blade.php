<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-gray-200 leading-tight">
            {{ __('Hasil Pencarian untuk:') }} <span class="italic">"{{ $query }}"</span>
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @if ($complaints->isEmpty())
                    <div class="bg-white dark:bg-black overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6 text-center text-slate-600 dark:text-gray-400">
                            <i class="fas fa-search fa-2x mb-4"></i>
                            <p class="font-semibold">Tidak ada laporan yang ditemukan.</p>
                            <p class="text-sm mt-1">Coba gunakan kata kunci lain yang lebih umum.</p>
                        </div>
                    </div>
                @else
                    @foreach ($complaints as $complaint)
                        <a href="{{ route('pengaduan.show', $complaint) }}" class="block bg-white dark:bg-black overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">{{ Str::title(str_replace('_', ' ', $complaint->category)) }}</p>
                                        <h3 class="text-lg font-bold text-slate-900 dark:text-gray-100 mt-1">{{ $complaint->title }}</h3>
                                    </div>
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full
                                        @switch($complaint->status)
                                            @case('dikirim') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 @break
                                            @case('diproses') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @break
                                            @case('selesai') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @break
                                            @default bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                        @endswitch
                                    ">
                                        {{ Str::title($complaint->status) }}
                                    </span>
                                </div>
                                <p class="text-sm text-slate-600 dark:text-gray-400 mt-2">
                                    {{ Str::limit($complaint->description, 150) }}
                                </p>
                                <div class="flex items-center justify-between text-xs text-slate-500 dark:text-gray-500 mt-4 pt-4 border-t border-slate-200 dark:border-gray-700">
                                    <span><i class="fas fa-user-circle mr-1"></i> Dilaporkan oleh {{ $complaint->user->name }}</span>
                                    <span><i class="fas fa-clock mr-1"></i> {{ $complaint->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach

                    <!-- Pagination Links -->
                    <div class="mt-8">
                        {{ $complaints->appends(['q' => $query])->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
