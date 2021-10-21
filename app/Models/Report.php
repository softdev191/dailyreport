<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\ReportDetail;

class Report extends Model
{
    use Notifiable;

    protected $fillable = [
        'spot_id', 'user_id', 'worker_id', 'report_date', 'last_user_id', 'author'
    ];

    protected $table = 'reports';
}
