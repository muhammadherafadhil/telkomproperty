<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    // Define the relationship between Log and Like
    public function likes()
    {
        return $this->hasMany(Like::class, 'log_id');  // Make sure the foreign key is correct in your likes table
    }

    // Other methods and relationships can be defined here
}
