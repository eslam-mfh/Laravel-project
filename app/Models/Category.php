<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public  function  service()
    {
        return $this->hasMany(Service::class);
    }
    protected $fillable =[

        'name',
        'description',
        'image',
    ];
}
