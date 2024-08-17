<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    public function dates(){
        return $this->belongsTo(Date::class);
    }

    public function services(){
        return $this->belongsTo(Service_Specialist::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    protected $fillable =[
        'user_id',
        'service__specialists_id',
        'date_id',
        'notes',
    ];


}
