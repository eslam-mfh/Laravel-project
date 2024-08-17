<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableSlot extends Model
{
    use HasFactory;
    protected $fillable = ['specialist_id', 'service_id', 'date', 'time', 'is_booked'];
    public function specialist()
    {
        return $this->belongsTo(Specialist::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }



}
