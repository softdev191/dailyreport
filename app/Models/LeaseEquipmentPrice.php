<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;

class LeaseEquipmentPrice extends Model
{
    use Notifiable;

    protected $fillable = [
        'equipment_id', 'type_id', 'price', 'start_date'
    ];

    protected $table = 'lease_equipments_prices';
}
