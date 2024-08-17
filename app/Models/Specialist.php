<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialist extends Model
{
    use HasFactory;
    public function serviceSpecialest()
    {
        return $this->hasMany(Service_Specialist::class);
    }
    protected $fillable =[

        'name',
        'description' ,

    ];
    public function availableSlots()
    {
        return $this->hasMany(AvailableSlot::class);
    }


}
