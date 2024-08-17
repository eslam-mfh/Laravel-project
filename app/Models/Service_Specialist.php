<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_Specialist extends Model
{
    use HasFactory;
    public function services()
    {
        return $this ->belongsToMany(Service::class);
    }
    public function specialist()
    {
        return $this ->belongsToMany(Specialist::class);
    }

    public function reservation(){
        return $this->hasMany(Reservation::class);
    }
    protected $fillable =[

        'specialist_id',
        'service_id',
    ];
}
