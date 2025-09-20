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
     * @var array
     */
    // ---- PERBAIKAN: LENGKAPI SEMUA FIELD FORM DI SINI ----
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'status',
        'priority',
        'location_text',
        // Tambahkan semua field alamat
        'kabupaten',
        'kecamatan',
        'desa',
        'kampung',
        'rt_rw',
        // Tambahkan field untuk foto KTP
        'foto_ktp',
    ];
    
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
        return $this->hasMany(Response::class)->latest();
    }
}
