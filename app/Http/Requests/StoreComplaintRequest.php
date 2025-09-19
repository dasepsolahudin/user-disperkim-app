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
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:jalan_rusak,penerangan_jalan,saluran_air,taman_kota,fasilitas_umum,lainnya'],
            'description' => ['required', 'string'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            
            /* ================================================
            PERUBAHAN DI SINI: Aturan untuk 'location_text' diubah
            ================================================
            - 'required' dihapus, dan diganti dengan 'nullable'.
            - Ini berarti kolom ini sekarang boleh kosong.
            */
            'location_text' => ['nullable', 'string', 'max:255'], 
            
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }
}