<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreComplaintRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:rutilahu,infrastruktur,tata_kota,air_bersih_sanitasi',
            'description' => 'required|string',
            'priority' => 'nullable|string|in:Rendah,Sedang,Tinggi',
            'district' => 'required|string|max:100',
            'sub_district' => 'required|string|max:100',
            'village' => 'required|string|max:100',
            'kampung' => 'nullable|string|max:100',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'phone_number' => 'required|string|max:20',
            'location_text' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120',
            'ktp_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ];
    }
}