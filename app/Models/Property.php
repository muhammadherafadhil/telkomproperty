<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'price',
        'type',
    ];

    // Menambahkan scope untuk pencarian berdasarkan nama, lokasi dan harga
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', '%' . $term . '%')
                     ->orWhere('location', 'like', '%' . $term . '%');
    }

    public function scopeFilterByPrice($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeFilterByLocation($query, $location)
    {
        return $query->where('location', $location);
    }
}
