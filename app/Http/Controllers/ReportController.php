<?php

namespace App\Http\Controllers;

use App\Exports\ExcelDown;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\LeaseCompany;
use App\Models\LeaseType;
use App\Models\LeaseEquipment;
use App\Models\Worker;
use App\Models\WorkerPrice;
use App\Models\Spot;
use App\Models\Report;
use App\Models\ReportDetail;
use App\Models\Tax;
use GuzzleHttp;
use DB;

use App\Http\Services\ReportService;

class ReportController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){
        return view('daily.pages.index');
    }

    public function report(Request $request){
        $id = $request->location_id;
        $spot = Spot::find($id);
        if ($spot->cur_user_id == 0 || $spot->cur_user_id == Auth::user()->id) {
            $spot->update(['cur_user_id' => Auth::user()->id]);
        }
        $finished = false;
        if ($spot->ended_at != null && $spot->ended_at < date("Y-m-d H:i:s")) {
            $finished = true;
        }
        $data = [
            'id' => $id,
            'spot' => $spot,
            'finished' => $finished,
        ];

        return view('daily.pages.report', $data);
    }

    public function rollback_complete(Request $request) {
        $id = $request->id;
        $spot = Spot::find($id);
        $spot->ended_at = null;
        $spot->save();
    }

    public function report_detail(Request $request){
        $id = $request->location_id;
        $date = $request->location_date;
        $spot = Spot::find($id);
        $report_model = Report::where(['spot_id' => $id, 'report_date' => $date])->first();
        if ($report_model) {
            $author = $report_model->author ? $report_model->author : User::find($report_model->user_id)->name;
            $report_id = $report_model->id;
        } else {
            $author = $report_model->author ? $report_model->author : User::find($spot->user_id)->name;
            $report_id = 0;
        }

        $report_details = ReportDetail::where(['report_id' => $report_id])->get();

        foreach ($report_details as &$item) {
            if ($item->worker_value == null) {
                $item->worker_value = 0;
            } else {
                $item->worker_value = round($item->worker_value * $item->percentage * (100 + $item->tax * $item->worker_tax) / 100);
            }
            if ($item->trucks_company_id > 0) {
                $item->arr_car_type = LeaseType::get_lease_type_list_all($item->trucks_company_id);
                $item->arr_car_equip = LeaseEquipment::get_lease_equipment_list_all(0, $item->trucks_company_id);
            }
            if ($item->equipment_company_id > 0) {
                $item->arr_tool_type = LeaseType::get_lease_type_list_all($item->equipment_company_id);
                $item->arr_tool_equip = LeaseEquipment::get_lease_equipment_list_all(1, $item->equipment_company_id);
            }
            if ($item->trucks_value == null) {
                $item->trucks_value = 0;
            } else {
                $item->trucks_value = round($item->trucks_value * (100 + $item->tax) / 100);
            }
            if ($item->equipment_value == null) {
                $item->equipment_value = 0;
            } else {
                $item->equipment_value = round($item->equipment_value * (100 + $item->tax) / 100);
            }
        }
        $cur_date = date('Y-m-d');

        $workers = Worker::where('start_date', '<=', $cur_date)
            // ->where('visible', 1)
            ->orderBy('position', 'ASC')
            ->get();
        $company = LeaseCompany::where(['delete' => 0])->get();

        $data = [
            'id' => $id,
            'date' => $date,
            'spot' => $spot,
            'author' => $author,
            'worker' => $workers,
            'company' => $company,
            'report_details' => $report_details,
            'report_cnt' => count($report_details),
        ];
        // dd($data);
        return view('daily.pages.report_detail', $data);
    }

    public function get_location_status(Request $request) {
        $id = $request->location_id;
        $spot = Spot::find($id);
        $role = 0;
        $time_now = strtotime(date('Y-m-d H:i:s'));
        $last_update_time = strtotime($spot->updated_at);
        $last_user = User::find($spot->cur_user_id);
        $last_username = '';
        if ($last_user) {
            $last_username = $last_user->name;
        }
        if (Auth::check() && ($spot->cur_user_id == 0 || $spot->cur_user_id == Auth::user()->id || ($time_now - $last_update_time) > 1800)) {
            $spot->update(['cur_user_id' => Auth::user()->id]);
            $role = 1;
            $last_username = '';
        }
        return [$role, $last_username];
    }

    public function add_location(Request $request) {
        Spot::create([
            "user_id" => Auth::user()->id,
            "name" => $request->location_name ? $request->location_name : '',
            "address" => $request->locate_address ? $request->locate_address : '',
            "contractor" => $request->order_name ? $request->order_name : '',
            "contract_price" => $request->order_cost ? $request->order_cost : 0,
            "started_at" => $request->locate_startdate ? $request->locate_startdate : null,
            "last_user_id" => Auth::user()->id,
        ]);
        return 1;
    }

    public function delete_location(Request $request) {
        $spot = Spot::find($request->id);
        $reports = Report::where(['spot_id' => $request->id])->get();

        foreach ($reports as $report) {
            DB::table('reports_details')
                ->where(['report_id' => $report->id])
                ->delete();
        }

        DB::table('reports')
            ->where(['spot_id' => $request->id])
            ->delete();

        return $spot->delete();
    }

    public function change_location_editor(Request $request) {
        $spot = Spot::find($request->id);
        if ($spot && $spot->cur_user_id == Auth::user()->id) {
            $spot->update(['cur_user_id' => 0]);
        }
        return 1;
    }

    public function delete_report(Request $request) {
        $report = Report::where(['spot_id' => $request->id, 'report_date' => $request->date])->first();
        if ($report) {
            DB::table('reports_details')
                ->where(['report_id' => $report->id])
                ->delete();
            return $report->delete();
        } else {
            return 0;
        }
    }

    public function complete_location(Request $request) {
        $spot = Spot::find($request->id);
        $date = $request->date;

        return $spot->update([
            "status" => 1,
            "ended_at" => date_format(date_create($date), 'Y-m-d H:i:s'),
            "last_user_id" => Auth::user()->id,
        ]);
    }

    public function change_location(Request $request) {
        $spot = Spot::find($request->id);

        $spot->update([
            "name" => $request->location_name,
            "address" => $request->locate_address,
            "contractor" => $request->order_name,
            "contract_price" => $request->order_cost,
            "content" => $request->work_content,
            "started_at" => $request->locate_startdate ? $request->locate_startdate : null,
            "last_user_id" => Auth::user()->id,
        ]);

        return number_format(round($request->order_cost));
    }

    public function report_print(Request $request) {
        return (new ExcelDown)->forYear($request->location_id)->download(trans('login.daily_report_filename'));
    }

    public function get_miss_list(Request $request) {
        $limit = $request->length;
        $offset = $request->start;
        $query = Spot::get_report_miss();
        $total = $query->get();
        $reports = $query->skip($offset)->take($limit)->get();
        $totalFiltered = count($total);

        $return_data = array();
        foreach($reports as $r) {
            array_push($return_data, [
                $r->address,
                $r->name,
                date('Y/m/d', strtotime($r->report_date)),
                $r->contractor,
                $r->author ? $r->author : User::find($r->user_id)->name,
                $r->id,
                $r->report_date,
            ]);
        }

        $json_data = array(
            "draw" => intval($request->draw),
            "recordsTotal" => intval($totalFiltered),
            "recordsFiltered" => intval($totalFiltered),
            "memberCnt" => number_format(intval($totalFiltered)),
            "data" => $return_data
        );

        return response() ->json($json_data);
    }

    public function get_spot_list(Request $request) {
        $limit = $request->length;
        $offset = $request->start;
        $name = $request->name;
        $address = $request->address;
        $date_start1 = $request->date_start1;
        $date_end1 = $request->date_end1;
        $date_start2 = $request->date_start2;
        $date_end2 = $request->date_end2;
        $name_like = '%' . $name . '%';
        $address_like = '%' . $address . '%';

        $spots = Spot::where('name', 'like', $name_like)->where('address', 'like', $address_like);
        $total = Spot::where('name', 'like', $name_like)->where('address', 'like', $address_like);

        if ($name == '' && $address == '' && $date_start1 == '' && $date_end1 == '' && $date_start2 == '' && $date_end2 == '') {
            $spots = $spots->where('ended_at', '>', date('Y-m-d H:i:s'))->orWhere('ended_at', null);
        }

        if ($date_start1 != '') {
            $spots = $spots->where('started_at', '>=', $date_start1);
        }
        if ($date_end1 != '') {
            $spots = $spots->where('started_at', '<=', $date_end1);
        }

        if ($date_start2 != '') {
            $spots = $spots->whereBetween('ended_at', '>=' ,$date_start2);
        }
        if ($date_end2 != '') {
            $spots = $spots->whereBetween('ended_at', '<=' ,$date_start2);
        }

        $spots = $spots->orderBy('created_at', 'DESC')
            ->skip($offset)->take($limit)
            ->get();

        $total = $total->orderBy('created_at', 'DESC')
            ->get();

        $totalFiltered = count($total);

        $return_data = array();

        foreach($spots as $spot) {
            $temp = array();

            $stat = ReportService::report_spot($spot->id);

            $curUser = User::find($spot->cur_user_id);
            $temp[0] = $curUser ? $curUser->name : '';
            $temp[1] = $spot->address;
            $temp[2] = $spot->name;
            $temp[3] = number_format($stat['worker_cnt']) . trans('login.member');
            $temp[4] = number_format(round($stat['worker_sum'])) . trans('login.won');
            $temp[5] = number_format(round($stat['total_sum'])) . trans('login.won');
            $temp[6] = number_format(round($stat['profit'])) . trans('login.won');
            $temp[7] = round($stat['profit_rate'], 2) . '%';
            $temp[8] = $spot->id;
            array_push($return_data, $temp);
        }


        $json_data = array(
            "draw" => intval($request->draw),
            "recordsTotal" => intval($totalFiltered),
            "recordsFiltered" => intval($totalFiltered),
            "memberCnt" => number_format(intval($totalFiltered)),
            "data" => $return_data
        );

        return response() ->json($json_data);
    }

    public function get_report_list(Request $request) {
        $limit = $request->length;
        $offset = $request->start;
        $location_id = $request->location_id;

        $reports = Report::where(['spot_id' => $location_id])->orderBy('report_date', 'DESC')->skip($offset)->take($limit)->get();
        $total = Report::where(['spot_id' => $location_id])->get();
        $totalFiltered = count($total);

        $return_data = array();

        foreach($reports as $report) {
            $row = array();
            $stat = ReportService::report_one($report->id);
            $row[0] = date('Y/m/d', strtotime($report->report_date));
            // $row[1] = User::find($report->user_id)->name;
            $row[1] = $report->author ? $report->author : User::find($report->user_id)->name;
            $row[2] = "'" . date('Y-m-d', strtotime($report->report_date)) . "'";
            // $worker_cnt = $stat['worker']['count'];
            // $worker_sum = $stat['worker']['sum'];
            // $row[1] = number_format($worker_cnt).trans('login.member').'/'.
            //     number_format(round($worker_sum)).trans('login.won');
            // $lancer_cnt = $stat['lancer']['count'];
            // $lancer_sum = $stat['lancer']['sum'];
            // $row[2] = number_format($lancer_cnt).trans('login.member').'/'.
            //     number_format(round($lancer_sum)).trans('login.won');
            // $truck_sum = $stat['equip']['equip'];
            // $equip_sum = $stat['equip']['truck'];
            // $row[3] = number_format(round($truck_sum + $equip_sum)).trans('login.won');
            // $total_sum = $stat['total'];
            // $row[4] = number_format(round($total_sum)).trans('login.won');
            // $row[5] = "'" . date('Y-m-d', strtotime($report->report_date)) . "'";

            array_push($return_data, $row);
        }

        $json_data = array(
            "draw" => intval($request->draw),
            "recordsTotal" => intval($totalFiltered),
            "recordsFiltered" => intval($totalFiltered),
            "memberCnt" => number_format(intval($totalFiltered)),
            "data" => $return_data
        );

        return response()->json($json_data);
    }

    public function create_report(Request $request) {
        $location_id = $request->id;
        $date = $request->date;
        $report = Report::where('spot_id', $location_id)->where('report_date', $date)->first();
        if ($report) {
            return 0;
        } else {
            $report_id = Report::create([
                "spot_id" => $location_id,
                "report_date" => $date,
                "user_id" => Auth::user()->id,
                "last_user_id" => Auth::user()->id,
                "author" => $request->author,
            ])->id;
            return $report_id;
        }
    }

    public function save_report_detail(Request $request) {
        $location_id = $request->id;
        $date = $request->date;
        $report_detail = GuzzleHttp\json_decode($request->report_detail);
        $report_model = Report::where(['spot_id' => $location_id, 'report_date' => $date])->first();

        if ($report_model) {
            $report_id = $report_model->id;
            $report_model->update([
                "last_user_id" => Auth::user()->id,
            ]);
        }
        $tax_model = Tax::currentTax($date);
        $tax = 10;
        if ($tax_model) {
            $tax = $tax_model->price;
        }

        $prev_details = ReportDetail::where('report_id', $report_model->id)->get();
        foreach ($prev_details as $pd) {
            $exist = false;
            foreach ($report_detail as $r) {
                if ($r->id == $pd->id) {
                    $exist = true;
                    break;
                }
            }
            if (!$exist) {
                $pd->delete();
            }
        }

        foreach ($report_detail as $item) {
            $item->worker_id = $item->worker_id == 0 ? null : $item->worker_id;
            $item->worker_type = $item->worker_id ? Worker::find($item->worker_id)->type : null;
            $item->percentage = $item->worker_id == null ? null : $item->percentage;
            $item->car_company_id = $item->car_company_id == 0 ? null : $item->car_company_id;
            $item->car_type_id = $item->car_type_id == 0 ? null : $item->car_type_id;
            $item->car_eqiup_id = $item->car_eqiup_id == 0 ? null : $item->car_eqiup_id;
            $item->tool_company_id = $item->tool_company_id == 0 ? null : $item->tool_company_id;
            $item->tool_type_id = $item->tool_type_id == 0 ? null : $item->tool_type_id;
            $item->tool_eqiup_id = $item->tool_eqiup_id == 0 ? null : $item->tool_eqiup_id;
            $item->disposal_name = $item->disposal_name == '' ? null : $item->disposal_name;
            $item->disposal_value = $item->disposal_value == '' ? null : $item->disposal_value;
            $item->operating_name = $item->operating_name == '' ? null : $item->operating_name;
            $item->operating_value = $item->operating_value == '' ? null : $item->operating_value;
            $item->etc_name = $item->etc_name == '' ? null : $item->etc_name;
            $item->etc_value = $item->etc_value == '' ? null : $item->etc_value;

            $item->worker_value = null;
            $item->tax = $tax;
            $item->worker_tax = 0;
            if ($item->worker_id != null) {
                $worker_price = Worker::find($item->worker_id)->currentPrice($date);
                $item->worker_value = $worker_price->price;
                $item->worker_tax = $worker_price->tax;
            }
            $item->car_eqiup_value = null;
            if ($item->car_eqiup_id && $item->car_type_id) {
                $car_price = LeaseEquipment::find($item->car_eqiup_id)->currentPrice($item->car_type_id, $date);
                $item->car_eqiup_value = $car_price ? $car_price->price : 0;
            }
            $item->tool_eqiup_value = null;
            if ($item->tool_eqiup_id && $item->tool_type_id) {
                $tool_price = LeaseEquipment::find($item->tool_eqiup_id)->currentPrice($item->tool_type_id, $date);
                $item->tool_eqiup_value = $tool_price ? $tool_price->price : 0;
            }

            $report_detail = ReportDetail::find($item->id);

            if ($report_detail) {
                $report_detail->update([
                    "worker_id" => $item->worker_id,
                    "worker_type" => $item->worker_type,
                    "worker_value" => $item->worker_value,
                    "worker_tax" => $item->worker_tax,
                    "percentage" => $item->percentage,
                    "tax" => $item->tax,
                    "trucks_company_id" => $item->car_company_id,
                    "trucks_type_id" => $item->car_type_id,
                    "trucks_tool_id" => $item->car_eqiup_id,
                    "trucks_value" => $item->car_eqiup_value,
                    "equipment_company_id" => $item->tool_company_id,
                    "equipment_type_id" => $item->tool_type_id,
                    "equipment_tool_id" => $item->tool_eqiup_id,
                    "equipment_value" => $item->tool_eqiup_value,
                    "disposal" => $item->disposal_name,
                    "disposal_value" => $item->disposal_value,
                    "defense" => $item->operating_name,
                    "defense_value" => $item->operating_value,
                    "etc" => $item->etc_name,
                    "etc_value" => $item->etc_value,
                    "last_user_id" => Auth::user()->id,
                ]);
            } else {
                ReportDetail::create([
                    "report_id" => $report_id,
                    "user_id" => Auth::user()->id,
                    "worker_id" => $item->worker_id,
                    "worker_type" => $item->worker_type,
                    "worker_tax" => $item->worker_tax,
                    "worker_value" => $item->worker_value,
                    "percentage" => $item->percentage,
                    "tax" => $item->tax,
                    "trucks_company_id" => $item->car_company_id,
                    "trucks_type_id" => $item->car_type_id,
                    "trucks_tool_id" => $item->car_eqiup_id,
                    "trucks_value" => $item->car_eqiup_value,
                    "equipment_company_id" => $item->tool_company_id,
                    "equipment_type_id" => $item->tool_type_id,
                    "equipment_tool_id" => $item->tool_eqiup_id,
                    "equipment_value" => $item->tool_eqiup_value,
                    "disposal" => $item->disposal_name,
                    "disposal_value" => $item->disposal_value,
                    "defense" => $item->operating_name,
                    "defense_value" => $item->operating_value,
                    "etc" => $item->etc_name,
                    "etc_value" => $item->etc_value,
                    "last_user_id" => Auth::user()->id,
                ]);
            }
        }

        return $report_id;
    }
}
