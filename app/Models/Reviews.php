<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $fillable = [
        'user_id' ,
        'session_id',
        'review',
        'type',
    ];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
