<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'available_slots_id',
        'service',
        'specialist',
        'date',
        'time',
        'status',
        'type',

    ];

    public function availableSlot()
    {
        return $this->belongsTo(AvailableSlot::class, 'available_slots_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function review()
    {
        return $this->hasOne(Reviews::class);
    }

}
