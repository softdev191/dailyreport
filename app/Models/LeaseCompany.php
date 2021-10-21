<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LeaseCompany extends Model
{
    use Notifiable;

    protected $fillable = [
        'name', 'delete'
    ];

    protected $table = 'lease_companies';
}
