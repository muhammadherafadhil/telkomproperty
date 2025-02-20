<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'log_id']; // Gunakan 'log_id' bukan 'history_log_id'

    public function historyLog()
    {
        return $this->belongsTo(HistoryLog::class, 'log_id'); // Gunakan 'log_id'
    }
}
