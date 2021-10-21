<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;

class LeaseType extends Model
{
    use Notifiable;

    protected $fillable = [
        'company_id', 'name', 'delete'
    ];

    protected $table = 'lease_types';

    public static function get_lease_type_detail($id) {
        return DB::table('lease_types')
            ->join('lease_companies', 'lease_companies.id', '=', 'lease_types.company_id')
            ->select('lease_types.*', 'lease_companies.name as company_name', 'lease_companies.id as company_id')
            ->where('lease_types.id', '=', $id)
            ->first();
    }

    public static function get_lease_type_list($company_id, $limit, $offset) {
        return DB::table('lease_types')
            ->join('lease_companies', 'lease_companies.id', '=', 'lease_types.company_id')
            ->select('lease_types.*', 'lease_companies.name as company_name')
            ->where(['lease_companies.delete' => 0, 'lease_types.delete' => 0, 'lease_companies.id' => $company_id])
            ->skip($offset)->take($limit)
            ->get();
    }

    public static function get_lease_type_list_all($company_id) {
        return DB::table('lease_types')
            ->join('lease_companies', 'lease_companies.id', '=', 'lease_types.company_id')
            ->select('lease_types.*', 'lease_companies.name as company_name')
            ->where(['lease_companies.delete' => 0, 'lease_types.delete' => 0, 'lease_companies.id' => $company_id])
            ->get();
    }

    public static function get_lease_type_list_count($company_id) {
        return count(DB::table('lease_types')
            ->join('lease_companies', 'lease_companies.id', '=', 'lease_types.company_id')
            ->select('*')
            ->where(['lease_companies.delete' => 0, 'lease_types.delete' => 0, 'lease_companies.id' => $company_id])
            ->get());
    }
}
