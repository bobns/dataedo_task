<?php

namespace App\Users\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $hidden = [
        'password',
    ];

    protected $fillable = [
        'name',
        'login',
        'email',
        'password'
    ];
}