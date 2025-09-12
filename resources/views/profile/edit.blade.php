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
                    <div class="relative shrink-0">
                        @if(Auth::user()->photo)
                            <img id="preview-photo" class="h-20 w-20 rounded-full object-cover border-2 border-indigo-500 shadow" 
                                src="{{ asset('storage/' . Auth::user()->photo) }}" 
                                alt="Foto Profil">
                        @else
                            <img id="preview-photo" class="h-20 w-20 rounded-full object-cover border-2 border-gray-400 shadow" 
                                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF" 
                                alt="Foto Profil">
                        @endif

                        {{-- Form Upload Foto --}}
                        <form id="photo-form" action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="absolute bottom-0 right-0">
                            @csrf
                            <label for="photo" 
                                   class="bg-indigo-600 text-white p-2 rounded-full shadow cursor-pointer hover:bg-indigo-700">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" 
                                     class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M3 7h2l2-3h10l2 3h2a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V8a1 1 0 011-1z" />
                                    <circle cx="12" cy="13" r="3" stroke="currentColor" stroke-width="2"/>
                                </svg>
                            </label>
                            <input id="photo" type="file" name="photo" class="hidden"
                                   accept="image/*" capture="user"
                                   onchange="previewAndSubmit(event)">
                        </form>
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

    <script>
    function previewAndSubmit(event) {
        const reader = new FileReader();
        reader.onload = function(){
            document.getElementById('preview-photo').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);

        // langsung submit form upload
        document.getElementById('photo-form').submit();
    }
    </script>
</x-app-layout>
