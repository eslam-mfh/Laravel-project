<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Set the user's password.
     *
     * @param  string  $value
     * @return void
     */


    public function roles(){

        return $this->belongsTo(Role::class);
    }
    public function reservation(){
        return $this->hasMany(Reservation::class);
    }
    public function bookOffer()
    {
        return $this->hasMany(BookOffers::class);
    }
    public function availableSlot(){
        return $this->hasMany(AvailableSlot::class);
    }

    public function session(){
        return $this->hasMany(Session::class);
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    public function review()
    {
        return $this->hasMany(Reviews::class);
    }


}
