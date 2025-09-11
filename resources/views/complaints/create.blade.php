<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-6">

        <!-- Judul -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-2xl font-bold text-gray-800">📝 Buat Pengaduan Baru</h2>
            <p class="mt-2 text-gray-600">Silakan isi formulir di bawah ini untuk membuat laporan pengaduan Anda.</p>
        </div>

        <!-- Form -->
        <div class="bg-white p-6 rounded-xl shadow">
            <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Judul -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Judul Pengaduan</label>
                    <input type="text" name="title" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300" required>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                    <textarea name="description" rows="5" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-300" required></textarea>
                </div>

                <!-- Upload Foto -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Lampiran Foto</label>
                    <input type="file" name="photo" class="w-full text-gray-700">
                </div>

                <!-- Tombol -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        🚀 Kirim Pengaduan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
