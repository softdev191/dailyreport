<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    //
    protected $fillable = ['price', 'start_date'];

    public static function currentTax($date) {
        return static::where('start_date', '<', $date)->orderBy('start_date', 'DESC')->first();
    }
}
