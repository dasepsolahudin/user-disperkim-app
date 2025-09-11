{{-- resources/views/pengaduan/show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <a href="{{ route('pengaduan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mb-6">
                        &larr; Kembali ke Daftar Pengaduan
                    </a>
                    
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $complaint->title }}</h3>
                        <div class="flex items-center text-sm text-gray-500 mt-2">
                            <span class="mr-4">Kategori: <strong>{{ $complaint->category }}</strong></span>
                            <span>Tanggal Lapor: <strong>{{ $complaint->created_at->format('d F Y H:i') }}</strong></span>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h4 class="text-lg font-semibold mb-4">Status Pengaduan</h4>
                        <ol class="relative border-l border-gray-200 dark:border-gray-700">                  
                            <li class="mb-10 ml-4">
                                <div class="absolute w-3 h-3 bg-green-500 rounded-full mt-1.5 -left-1.5 border border-white"></div>
                                <time class="mb-1 text-sm font-normal leading-none text-gray-400">Langkah 1</time>
                                <h3 class="text-lg font-semibold text-gray-900">Laporan Dibuat</h3>
                                <p class="text-base font-normal text-gray-500">Pengaduan Anda telah kami terima pada tanggal {{ $complaint->created_at->format('d F Y') }}.</p>
                            </li>
                            <li class="mb-10 ml-4">
                                <div class="absolute w-3 h-3 {{ $complaint->status == 'Verifikasi' || $complaint->status == 'Pengerjaan' || $complaint->status == 'Selesai' ? 'bg-green-500' : 'bg-gray-300' }} rounded-full mt-1.5 -left-1.5 border border-white"></div>
                                <time class="mb-1 text-sm font-normal leading-none text-gray-400">Langkah 2</time>
                                <h3 class="text-lg font-semibold text-gray-900">Verifikasi Petugas</h3>
                                <p class="text-base font-normal text-gray-500">Laporan sedang diperiksa dan diverifikasi oleh petugas terkait.</p>
                            </li>
                            <li class="mb-10 ml-4">
                                <div class="absolute w-3 h-3 {{ $complaint->status == 'Pengerjaan' || $complaint->status == 'Selesai' ? 'bg-green-500' : 'bg-gray-300' }} rounded-full mt-1.5 -left-1.5 border border-white"></div>
                                <time class="mb-1 text-sm font-normal leading-none text-gray-400">Langkah 3</time>
                                <h3 class="text-lg font-semibold text-gray-900">Dalam Pengerjaan</h3>
                                <p class="text-base font-normal text-gray-500">Masalah yang dilaporkan sedang dalam proses penanganan oleh tim kami.</p>
                            </li>
                            <li class="ml-4">
                                <div class="absolute w-3 h-3 {{ $complaint->status == 'Selesai' ? 'bg-green-500' : 'bg-gray-300' }} rounded-full mt-1.5 -left-1.5 border border-white"></div>
                                <time class="mb-1 text-sm font-normal leading-none text-gray-400">Langkah 4</time>
                                <h3 class="text-lg font-semibold text-gray-900">Selesai</h3>
                                <p class="text-base font-normal text-gray-500">Pengaduan telah selesai ditangani. Terima kasih atas laporan Anda.</p>
                            </li>
                        </ol>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-lg font-semibold mb-2">Deskripsi Lengkap</h4>
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $complaint->description }}</p>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold mb-2">Galeri Foto</h4>
                            @if($complaint->photo)
                                <img src="{{ asset('storage/' . $complaint->photo) }}" alt="Foto Pengaduan" class="rounded-lg shadow-md w-full h-auto">
                            @else
                                <p class="text-gray-500">Tidak ada foto yang dilampirkan.</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-10 border-t pt-6">
                        <h4 class="text-lg font-semibold mb-4">Tanggapan dari Petugas</h4>
                        <div class="space-y-4">
                            <div class="p-4 bg-gray-50 rounded-lg border">
                                <p class="text-gray-800">Terima kasih atas laporannya. Tim kami akan segera melakukan verifikasi ke lokasi. Mohon ditunggu informasi selanjutnya.</p>
                                <p class="text-xs text-gray-500 mt-2">Oleh: Petugas Admin | 12 September 2025</p>
                            </div>
                            </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>