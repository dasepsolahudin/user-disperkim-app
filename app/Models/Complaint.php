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

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'status',
        'priority',
        'district',
        'sub_district',
        'village',
        'kampung',
        'rt',
        'rw',
        'phone_number',
        'location_text',
    ];

    // ... sisa relasi ...
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