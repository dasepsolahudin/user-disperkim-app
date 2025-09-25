<x-app-layout>
    {{-- HEADER HALAMAN --}}
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center">
                <i class="fas fa-map-marked-alt fa-lg text-blue-600 dark:text-blue-400"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    Peta Interaktif Disperkim
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Lokasi Kantor Dinas Perumahan dan Permukiman.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border dark:border-gray-700 overflow-hidden">
                
                {{-- Kontainer Peta Responsif --}}
                <div class="w-full" style="height: 70vh;">
                    {{-- Kode Iframe Anda dimasukkan di sini dan dibuat responsif --}}
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d6498.833076679432!2d107.87791429032143!3d-7.199726686215864!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sid!2sid!4v1758779736044!5m2!1sid!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>