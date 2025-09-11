<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-6 md:p-8 rounded-lg shadow-sm space-y-6">
                
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                        <div class="mb-3 sm:mb-0">
                            <p class="text-sm font-medium text-indigo-600 capitalize">
                                Kategori: {{ str_replace('_', ' ', $complaint->category) }}
                            </p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $complaint->title }}</h3>
                        </div>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full self-start 
                            @if($complaint->status == 'Selesai') bg-green-100 text-green-800 
                            @elseif($complaint->status == 'Pengerjaan') bg-yellow-100 text-yellow-800 
                            @elseif($complaint->status == 'Verifikasi') bg-blue-100 text-blue-800 
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $complaint->status }}
                        </span>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-700 mb-2 border-b pb-2">📝 Rincian Laporan</h4>
                    <p class="text-gray-600 leading-relaxed mt-4 whitespace-pre-wrap">{{ $complaint->description }}</p>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">📍 Lokasi Spesifik</h4>
                    <p class="text-gray-600 leading-relaxed">{{ $complaint->location_text ?: 'Tidak ada detail lokasi.' }}</p>
                </div>

                @if($complaint->photo)
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-2">📷 Foto Lampiran</h4>
                        <a href="{{ asset('storage/' . $complaint->photo) }}" target="_blank">
                            <img src="{{ asset('storage/' . $complaint->photo) }}" 
                                 alt="Foto Laporan" 
                                 class="rounded-lg shadow-md max-h-96 w-auto border hover:opacity-90 transition-opacity">
                        </a>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t">
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-1">📅 Dibuat Pada</h4>
                        <p class="text-gray-600">{{ $complaint->created_at->format('d F Y, H:i') }} WIB</p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-1">⚡ Terakhir Diperbarui</h4>
                        <p class="text-gray-600">{{ $complaint->updated_at->format('d F Y, H:i') }} WIB</p>
                    </div>
                </div>

                <div class="flex justify-start pt-4 border-t">
                    <a href="{{ route('complaints.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        ⬅️ Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>