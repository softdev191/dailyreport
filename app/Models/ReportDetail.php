<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ReportDetail extends Model
{
    use Notifiable;

    protected $fillable = [
        'report_id', 'user_id', 'worker_id', 'worker_type', 'worker_value', 'worker_tax', 'percentage', 'tax', 'trucks_company_id', 'trucks_type_id', 'trucks_tool_id', 'trucks_value',
        'equipment_company_id', 'equipment_type_id', 'equipment_tool_id', 'equipment_value',
        'disposal', 'disposal_value', 'defense', 'defense_value', 'etc', 'etc_value', 'last_user_id',
    ];

    protected $table = 'reports_details';
}
