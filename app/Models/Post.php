<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Menambahkan 'image_path' ke dalam $fillable untuk memungkinkan mass assignment
    protected $fillable = ['content', 'user_id', 'image_path'];

    /**
     * Relasi dengan model User
     * Setiap Post dimiliki oleh seorang User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan model Comment
     * Setiap Post dapat memiliki banyak komentar
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Relasi dengan model Like
     * Setiap Post dapat memiliki banyak likes
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
