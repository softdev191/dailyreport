<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Setting extends Model
{
    use Notifiable;

    protected $fillable = [
        'type', 'value',
    ];

    protected $table = 'settings';
}
