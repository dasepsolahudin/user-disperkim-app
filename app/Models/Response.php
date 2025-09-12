<?php

// app/Models/Response.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = ['complaint_id', 'user_id', 'content'];

    /**
     * Get the user that owns the response.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the complaint that the response belongs to.
     */
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}
