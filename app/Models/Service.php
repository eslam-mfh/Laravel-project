<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function serviceSpecialest()
    {
        return $this->hasMany(Service_Specialist::class);
    }
    public function offerService()
    {
        return $this->hasMany(Offer_Service::class);
    }
    public function availableSlots()
    {
        return $this->hasMany(AvailableSlot::class);
    }
    protected $fillable =[

        'category_id',
        'name',
        'description',
        'price',
        'topServices',
        'image',

    ];
}
