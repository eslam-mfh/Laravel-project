<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    public function offerService()
    {
        return $this->hasMany(Offer_Service::class);
    }
    public function bookOffer()
    {
        return $this->hasMany(BookOffers::class);
    }

    protected $fillable =[

        'name',
        'description',
        'price',
        'end',

    ];
}
