<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer_Service extends Model
{
    use HasFactory;
    public function services()
    {
        return $this ->belongsToMany(Service::class);
    }
    public function offer()
    {
        return $this ->belongsToMany(Offer::class);
    }

    protected $fillable =[

        'offer_id',
        'service_id',

    ];
}
