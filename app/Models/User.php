<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; // Add this line
use Illuminate\Notifications\Notifiable; // Add this line if not already present

class User extends Authenticatable
{
    use HasApiTokens, Notifiable; // Add HasApiTokens and Notifiable traits

    protected $primaryKey = 'user_id'; // Set the primary key

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'user_id', 'user_id');
    }
}