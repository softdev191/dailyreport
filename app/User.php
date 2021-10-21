<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'userID', 'password', 'role', 'delete',
    ];

    protected $hidden = [
        'password',
    ];

    protected $table = 'users';
}
