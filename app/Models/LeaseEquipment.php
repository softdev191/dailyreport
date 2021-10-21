<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;

class LeaseEquipment extends Model
{
    use Notifiable;

    protected $fillable = [
        'company_id', 'name', 'delete', 'type', 'start_date',
    ];

    protected $table = 'lease_equipments';

    public static function get_lease_equipment_detail($id) {
        return DB::table('lease_equipments')
            ->join('lease_companies', 'lease_companies.id', '=', 'lease_equipments.company_id')
            ->select('lease_equipments.*', 'lease_companies.name as company_name', 'lease_companies.id as company_id')
            ->where('lease_equipments.id', '=', $id)
            ->first();
    }

    public static function get_lease_equipment_list($type, $company_id, $limit, $offset) {
        return DB::table('lease_equipments')
            ->join('lease_companies', 'lease_companies.id', '=', 'lease_equipments.company_id')
            ->select('lease_equipments.*', 'lease_companies.name as company_name')
            ->where(['lease_equipments.type' => $type, 'lease_companies.delete' => 0, 'lease_equipments.delete' => 0, 'lease_companies.id' => $company_id])
            ->skip($offset)->take($limit)
            ->get();
    }

    public static function get_lease_equipment_list_all($type, $company_id) {
        return DB::table('lease_equipments')
            ->join('lease_companies', 'lease_companies.id', '=', 'lease_equipments.company_id')
            ->select('lease_equipments.*', 'lease_companies.name as company_name')
            ->where(['lease_equipments.type' => $type, 'lease_companies.delete' => 0, 'lease_equipments.delete' => 0, 'lease_companies.id' => $company_id])
            ->get();
    }

    public static function get_lease_equipment_list_count($type, $company_id) {
        return count(DB::table('lease_equipments')
            ->join('lease_companies', 'lease_companies.id', '=', 'lease_equipments.company_id')
            ->select('*')
            ->where(['lease_equipments.type' => $type, 'lease_companies.delete' => 0, 'lease_equipments.delete' => 0, 'lease_companies.id' => $company_id])
            ->get());
    }

    public function currentPrice($type, $date) {
        return LeaseEquipmentPrice::where('equipment_id', $this->id)
            ->where('type_id', $type)
            ->where('start_date', '<=', $date)
            ->orderBy('start_date', 'DESC')
            ->first();
    }
}
