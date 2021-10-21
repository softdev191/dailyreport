<?php

namespace App\Models;

use App\Http\Services\ReportService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;

class Spot extends Model
{
    use Notifiable;

    protected $fillable = [
        'user_id', 'name', 'address', 'code', 'contractor', 'contract_price', 'tax', 'content', 'status', 'ended_at', 'last_user_id', 'cur_user_id', 'started_at', 'ended_at'
    ];

    protected $table = 'spots';

    public static function get_report_miss() {
        return DB::table('spots')
            ->join('reports', 'spots.id', '=', 'reports.spot_id')
            ->join('reports_details', 'reports.id', '=', 'reports_details.report_id')
            ->select(
                'spots.id',
                'spots.address',
                'spots.name',
                'spots.contractor',
                'spots.contract_price',
                'spots.tax',
                'spots.code',
                'reports.report_date',
                'reports.user_id',
                'reports.author',
                'reports_details.report_id')
            ->where(function ($query) {
                $query->whereNull('reports_details.trucks_tool_id')
                    ->where('reports_details.trucks_company_id', '>', 0);
            })
            ->orwhere(function ($query) {
                $query->whereNull('reports_details.trucks_type_id')
                    ->where('reports_details.trucks_company_id', '>', 0);
            })
            ->orwhere(function ($query) {
                $query->whereNull('reports_details.equipment_type_id')
                    ->where('reports_details.equipment_company_id', '>', 0);
            })
            ->orwhere(function ($query) {
                $query->whereNull('reports_details.equipment_tool_id')
                    ->where('reports_details.equipment_company_id', '>', 0);
            })
            ->orwhere(function ($query) {
                $query->whereNull('reports_details.disposal')
                    ->whereNotNull('reports_details.disposal_value');
            })
            ->orwhere(function ($query) {
                $query->whereNull('reports_details.disposal_value')
                    ->whereNotNull('reports_details.disposal');
            })
            ->orwhere(function ($query) {
                $query->whereNull('reports_details.etc_value')
                    ->whereNotNull('reports_details.etc');
            })
            ->orwhere(function ($query) {
                $query->whereNull('reports_details.etc')
                    ->whereNotNull('reports_details.etc_value');
            })
            ->orderBy('spots.id', 'ASC')
            ->orderBy('reports.report_date', 'ASC');
    }

    public static function get_spot($id) {
        $spot = Spot::find($id);

        $order_cost = $spot->contract_price;

        $stat = ReportService::report_spot($id);

        $header = [
            '現場住所' => $spot->address,
            '現場名' => $spot->name,
            '元請名' => $spot->contractor,
            '請負金額' => number_format($spot->contract_price).'円',
            '累積工事額' => number_format($stat['total_sum']).'円',
            '累積人数' => $stat['worker_cnt'],
            '人件費総額' => number_format($stat['worker_sum']).'円',
            '純利益' => number_format($stat['profit']).'円',
            '利益率' => number_format((float)$stat['profit_rate'], 2, '.', '').'%'
        ];
        return $header;
    }

    public static function get_report($id) {
        $reports = DB::table('reports')
            ->select('id', 'report_date')
            ->where(['spot_id' => $id])
            ->orderBy('report_date', 'ASC')
            ->get();

        $data = array();
        foreach ($reports as $report) {
            $report_details = DB::table('reports_details')
                ->join('workers', 'workers.id', '=', 'reports_details.worker_id', 'left')
                ->join('lease_companies', 'lease_companies.id', '=', 'reports_details.trucks_company_id', 'left')
                ->join('lease_types', 'lease_types.id', '=', 'reports_details.trucks_type_id', 'left')
                ->join('lease_equipments', 'lease_equipments.id', '=', 'reports_details.trucks_tool_id', 'left')
                ->select('workers.name as worker_name', 'lease_companies.name as trucks_company_name', 'lease_types.name as trucks_type_name',
                    'reports_details.trucks_value', 'reports_details.equipment_value','reports_details.percentage', 'reports_details.worker_value', 'reports_details.worker_tax',
                    'reports_details.tax', 'reports_details.equipment_company_id', 'reports_details.equipment_type_id', 'reports_details.equipment_tool_id',
                    'lease_equipments.name as trucks_tool_name', 'reports_details.disposal', 'reports_details.disposal_value',
                     'reports_details.defense', 'reports_details.defense_value', 'reports_details.etc', 'reports_details.etc_value')
                ->where(['reports_details.report_id' => $report->id])
                ->get();

            if (count($report_details) == 0) {
                $tmp = ['a1' => date('Y/m/d', strtotime($report->report_date)), 'a2' => '', 'a3' => '', 'a4' => '', 'a5' => '', 'a6' => '', 'a7' => '', 'a8' => '', 'a9' => '', 'a10' => '', 'a11' => '', 'a12' => '', 'a13' => '', 'a14' => '', 'a15' => ''];
                array_push($data, $tmp);
            } else {
                for ($i = 0; $i < count($report_details); $i++) {
                    $date_label = $i == 0 ? date('Y/m/d', strtotime($report->report_date)) : '';
                    $worker_name = $report_details[$i]->worker_name == null ? '' : $report_details[$i]->worker_name;
                    $worker_value = $report_details[$i]->worker_value == null ? '' : number_format(round($report_details[$i]->worker_value * (100 + $report_details[$i]->tax * $report_details[$i]->worker_tax) * $report_details[$i]->percentage / 100));
                    $truck_company_name = $report_details[$i]->trucks_company_name == null ? '' : $report_details[$i]->trucks_company_name;
                    $truck_type_name = $report_details[$i]->trucks_type_name == null ? '' : $report_details[$i]->trucks_type_name;
                    $truck_tool_name = $report_details[$i]->trucks_tool_name == null ? '' : $report_details[$i]->trucks_tool_name;
                    $truck_type_tool_name = $truck_type_name . ' ' . $truck_tool_name;
                    $truck_value = $report_details[$i]->trucks_value == null ? '' : number_format($report_details[$i]->trucks_value * (100 + $report_details[$i]->tax) / 100);
                    $defense_value = $report_details[$i]->defense_value == null ? '' : number_format($report_details[$i]->defense_value);
                    $disposal_value = $report_details[$i]->disposal_value == null ? '' : number_format($report_details[$i]->disposal_value);
                    $etc_value = $report_details[$i]->etc_value == null ? '' : number_format($report_details[$i]->etc_value);
                    $equipment_company_name = $report_details[$i]->equipment_company_id == null ? '' : LeaseCompany::find($report_details[$i]->equipment_company_id)->name;
                    $equipment_type_name = $report_details[$i]->equipment_type_id == null ? '' : LeaseType::find($report_details[$i]->equipment_type_id)->name;
                    $equipment_tool_name = $report_details[$i]->equipment_tool_id == null ? '' : LeaseEquipment::find($report_details[$i]->equipment_tool_id)->name;
                    $equipment_type_tool_name = $equipment_type_name . ' ' . $equipment_tool_name;
                    $equipment_value = $report_details[$i]->equipment_value == null ? '' : number_format($report_details[$i]->equipment_value * (100 + $report_details[$i]->tax) / 100);

                    $tmp = [
                        'a1' => $date_label,
                        'a2' => $worker_name,
                        'a3' => $worker_value,
                        'a4' => $truck_company_name,
                        'a5' => $truck_value,
                        'a6' => $equipment_company_name,
                        'a7' => $equipment_value,
                        'a8' => $report_details[$i]->defense,
                        'a9' => $defense_value,
                        'a10' => $report_details[$i]->disposal,
                        'a11' => $disposal_value,
                        'a12' => $report_details[$i]->etc,
                        'a13' => $etc_value,
                        'a14' => $truck_type_tool_name,
                        'a15' => $equipment_type_tool_name,
                    ];
                    array_push($data, $tmp);
                }
            }
        }
        return $data;
    }
}
