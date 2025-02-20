<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'history_log_id', 'comment'];

    public function historyLog()
    {
        return $this->belongsTo(HistoryLog::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
