<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreComplaintRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Kita hanya mengizinkan pengguna yang sudah login untuk membuat pengaduan.
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // Semua aturan validasi dari controller kita pindahkan ke sini.
        return [
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:rutilahu,infrastruktur,tata_kota,air_bersih_sanitasi',
            'priority' => 'required|string|in:Rendah,Sedang,Tinggi',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'sub_district' => 'nullable|string|max:255', // Untuk Kampung/RW
            'location_text' => 'required|string', // Untuk Alamat Detail
            'description' => 'required|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // Maksimal 5MB per foto
            'ktp_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Maksimal 5MB
        ];
    }
}