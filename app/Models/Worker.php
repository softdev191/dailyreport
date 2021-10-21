<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Worker extends Model
{
    use Notifiable;

    protected $fillable = ['name', 'type', 'visible', 'start_date', 'position'];

    protected $table = 'workers';

    public function personals() {
        return $this->hasMany(Personal::class);
    }

    public function currentPrice($date) {
        return WorkerPrice::where('worker_id', $this->id)
            ->where('start_date', '<=', $date)
            ->orderBy('start_date', 'DESC')
            ->first();
    }
}
