<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComplaintRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Izinkan semua pengguna yang sudah login untuk membuat pengaduan
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // ---- PERBAIKAN: LENGKAPI ATURAN VALIDASI ----
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:rutilahu,infrastruktur,tata_kota,air_bersih_sanitasi',
            
            // Aturan untuk alamat
            'kabupaten' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'desa' => 'required|string|max:100',
            'kampung' => 'required|string|max:100',
            'rt_rw' => 'required|string|max:15',

            // Aturan untuk file upload
            // 'photos' harus berupa array dan minimal ada 1 file
            'photos' => 'required|array|min:1', 
            // Setiap item di dalam array 'photos' harus berupa gambar
            'photos.*' => 'required|image|mimes:jpeg,png,jpg|max:2048', 
            // 'foto_ktp' harus ada dan berupa gambar
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'photos.required' => 'Anda harus mengunggah setidaknya satu foto bukti.',
            'photos.*.image' => 'Semua file bukti harus berupa gambar.',
            'photos.*.mimes' => 'Format foto bukti harus JPG, PNG, atau JPEG.',
            'foto_ktp.required' => 'Foto KTP wajib diunggah untuk verifikasi.',
            'foto_ktp.image' => 'File KTP harus berupa gambar.',
        ];
    }
}
