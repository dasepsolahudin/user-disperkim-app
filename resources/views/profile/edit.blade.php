<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('👤 Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Profile Card dengan Foto --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex items-center gap-6 p-6 sm:p-8 border-b border-gray-200 dark:border-gray-700">
                    {{-- Foto Profil --}}
                    <div class="shrink-0">
                        @if(Auth::user()->photo)
                            <img class="h-20 w-20 rounded-full object-cover border-2 border-indigo-500 shadow" 
                                src="{{ asset('storage/' . Auth::user()->photo) }}" 
                                alt="Foto Profil">
                        @else
                            <img class="h-20 w-20 rounded-full object-cover border-2 border-gray-400 shadow" 
                                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF" 
                                alt="Foto Profil">
                        @endif
                    </div>

                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ Auth::user()->name }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ Auth::user()->email }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Update Profile Information --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Informasi Akun
                    </h3>
                    @include('profile.partials.update-profile-information-form', [
                        'buttonClass' => 'bg-blue-600 hover:bg-blue-700 text-white'
                    ])
                </div>
            </div>

            {{-- Update Password --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Ubah Password
                    </h3>
                    @include('profile.partials.update-password-form', [
                        'buttonClass' => 'bg-green-600 hover:bg-green-700 text-white'
                    ])
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-red-300">
                <div class="p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-red-600 dark:text-red-400 mb-4">
                        Hapus Akun
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Sekali akun Anda dihapus, semua data akan hilang secara permanen. Harap pikirkan dengan matang.
                    </p>
                    @include('profile.partials.delete-user-form', [
                        'buttonClass' => 'bg-red-600 hover:bg-red-700 text-white'
                    ])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
