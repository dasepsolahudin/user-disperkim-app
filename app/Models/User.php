<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'photo',
        'ktp_photo',
        
        // --- PERBAIKAN: MENAMBAHKAN SEMUA KOLOM DARI FORM ---
        'nik',
        'phone',
        'gender',
        'address',
        'province',
        'city',
        'district',
        'village',
        'rt',
        'rw',
        'full_address',
        'notification_preferences',
        
        // Kolom dari form yang namanya berbeda dengan di database
        'kabupaten', 
        'kecamatan',
        'desa',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'notification_preferences' => 'array',
        ];
    }

    /**
     * Mendefinisikan relasi "one-to-many": Satu User memiliki banyak Complaint.
     */
    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }
}