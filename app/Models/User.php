<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany; // Pastikan ini di-import
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     * 
     
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'notification_preferences' => 'array',
    ];
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo', // Sudah ada
        'kabupaten', // Tambahkan ini
        'kecamatan', // Tambahkan ini
        'desa',      // Tambahkan ini
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
            'notification_push' => 'boolean',
            'notification_email' => 'boolean',
            'notification_sms' => 'boolean',
            'auto_save' => 'boolean',
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