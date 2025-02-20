<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'rating', 'score', 'feedback'
    ];

    // Relasi dengan tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
