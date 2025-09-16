<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       'user_id',
        'category',
        'priority', // <-- TAMBAHKAN
        'title',
        'description',
        'location_text', // Ini untuk Alamat Detail
        'city',          // <-- TAMBAHKAN
        'district',      // <-- TAMBAHKAN
        'village',       // <-- TAMBAHKAN
        'sub_district',  // <-- TAMBAHKAN (untuk Kampung/RW)
        'status',
    ];

    /**
     * Mendefinisikan relasi "belongs-to": Satu Complaint dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function photos(): HasMany
    {
        return $this->hasMany(ComplaintPhoto::class);
    }

    public function responses()
{
    return $this->hasMany(Response::class)->latest(); // Mengambil semua tanggapan, diurutkan dari yang terbaru
}
}