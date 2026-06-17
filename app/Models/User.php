<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $primaryKey = 'user_id';
    
    protected $fillable = [
        'username',
        'password',
        'full_name',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class, 'user_id', 'user_id');
    }
}