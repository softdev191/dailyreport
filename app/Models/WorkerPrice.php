<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class WorkerPrice extends Model
{
    use Notifiable;

    protected $fillable = ['worker_id', 'price', 'tax', 'start_date'];

    protected $table = 'workers_prices';
}
