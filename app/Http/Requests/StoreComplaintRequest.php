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
         return [
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:rutilahu,infrastruktur,tata_kota,air_bersih_sanitasi',
            'priority' => 'nullable|string|in:Rendah,Sedang,Tinggi', // Diubah menjadi nullable
            'city' => 'nullable|string|max:255', // Diubah menjadi nullable
            'district' => 'nullable|string|max:255', // Diubah menjadi nullable
            'village' => 'nullable|string|max:255', // Diubah menjadi nullable
            'sub_district' => 'nullable|string|max:255',
            'location_text' => 'nullable|string', // Diubah menjadi nullable
            'description' => 'required|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'ktp_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ];
    }
}