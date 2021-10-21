<?php

namespace App\Http\Controllers;

use App\Models\ReportDetail;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\Worker;
use App\Models\WorkerPrice;
use App\Models\Tax;

class PersonalController extends Controller
{
    //
    public function store(Request $request) {
        $worker = Worker::find($request->id);
        if (!$worker) {
            $worker = Worker::create([
                "name" => $request->worker_name,
                "type" => $request->worker_type,
                "position" => Worker::max('position') + 1,
                "start_date" => $request->worker_labor_startdate,
            ]);
            WorkerPrice::create([
                "worker_id" => $worker->id,
                "price" => $request->worker_labor_cost,
                "start_date" => $request->worker_labor_startdate,
                "tax" => $request->worker_tax,
            ]);
        } else {
            WorkerPrice::create([
                "worker_id" => $worker->id,
                "price" => $request->worker_labor_cost,
                "start_date" => $request->worker_labor_startdate,
                "tax" => $request->worker_tax,
            ]);
            $this->update_price_all($worker->id);
        }
    }
    public function edit(Request $request) {
        $worker = Worker::find($request->id);
        if ($worker) {
            $worker->update([
                "name" => $request->worker_name,
                "tax" => $request->worker_tax,
                "start_date" => $request->worker_labor_startdate,
                "visible" => $request->worker_visible,
            ]);
        }
    }
    public function get_personal_list(Request $request) {
        return $this->get_personals($request, 1);
    }
    public function get_personal_hidden_list(Request $request) {
        return $this->get_personals($request, 0);
    }
    public function get_ordered_personals(Request $request) {
        $limit = $request->length;
        $offset = $request->start;
        $workers = Worker::where(['visible' => 1])
            ->orderBy('position')
            ->skip($offset)
            ->take($limit)
            ->get();
        $totalFiltered = count(Worker::where(['visible' => 1])->get());
        $return_data = array();
        foreach($workers as $w) {
            $row = [$w->position, $w->name, $w->type];
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
    public function get_personals(Request $request, $visible) {
        $limit = $request->length;
        $offset = $request->start;
        $type = $request->type;

        $mps = Worker::where(['visible' => $visible, 'type' => $type])
            ->orderBy('name', 'ASC')
            ->skip($offset)->take($limit)
            ->get();

        $totalFiltered = count(Worker::where(['visible' => $visible, 'type' => $type])->get());

        $return_data = array();

        foreach($mps as $mp) {
            $temp = array();

            $price_model = WorkerPrice::where('worker_id', $mp->id)
                ->orderBy('start_date', 'DESC')
                ->first();

            $temp[0] = $mp->name;
            $temp[1] = number_format($price_model ? $price_model->price : 0);
            $temp[2] = $mp->id;
            array_push($return_data, $temp);
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
    public function get(Request $request) {
        $worker = Worker::find($request->id);
        return response()->json($worker);
    }
    public function delete_personal(Request $request) {
        $mp = Worker::find($request->id);
        if ($mp) {
            WorkerPrice::where('worker_id', $mp->id)->delete();
            $mp->delete();
        }
        return true;
    }
    public function show(Request $request) {
        $worker = Worker::find($request->id);
        $worker->update([
            'visible' => 1,
        ]);
    }
    public function get_worker_price(Request $request) {
        $id = $request->id;
        $date = $request->date;

        $price = Worker::find($id)->currentPrice($date);
        $return_val = 0;

        if ($price) {
            if ($price->tax == 0) {
                $tax_val = 0;
            } else {
                $tax = Tax::currentTax($date);
                if ($tax) {
                    $tax_val = $tax->price;
                } else {
                    $tax_val = 10;
                }
            }
            $return_val = round($price->price * (100 + $tax_val) / 100);
        }

        return $return_val;
    }
    public function get_worker_prices(Request $request) {
        $mp = Worker::find($request->id);
        if ($mp) {
            $workers = WorkerPrice::where('worker_id', $mp->id)->get();
            $res = array();
            foreach($workers as $w) {
                array_push($res, [number_format($w->price), $w->start_date, $w->id]);
            }
            $totalFiltered = count($workers);
        } else {
            $res = array();
            $totalFiltered = 0;
        }
        $json_data = array(
            "draw" => intval($request->draw),
            "recordsTotal" => intval($totalFiltered),
            "recordsFiltered" => intval($totalFiltered),
            "memberCnt" => number_format(intval($totalFiltered)),
            "data" => $res
        );
        return response()->json($json_data);
    }
    public function get_price(Request $request) {
        $price = WorkerPrice::find($request->id);
        return response()->json($price);
    }
    public function edit_price(Request $request) {
        $price = WorkerPrice::find($request->id);
        if ($price) {
            $price->update([
                'price' => $request->worker_labor_cost,
                'start_date' => $request->worker_labor_startdate,
                'tax' => $request->worker_tax,
            ]);
        } else {
            $price = WorkerPrice::create([
                "worker_id" => $request->worker_id,
                "price" => $request->worker_labor_cost,
                "start_date" => $request->worker_labor_startdate,
                "tax" => $request->worker_tax,
            ]);
        }
        $worker = Worker::find($price->worker_id);
        $this->update_price_all($worker->id);
    }
    public function delete_price(Request $request) {
        $price = WorkerPrice::find($request->id);
        $worker = Worker::find($price->worker_id);
        if ($price) $price->delete();
        $this->update_price_all($worker->id);
        return true;
    }
    public function update_price_all($worker_id) {
        $worker = Worker::find($worker_id);
        $details = ReportDetail::where('worker_id', $worker_id)->get();
        foreach($details as $dt) {
            $report = Report::find($dt->report_id);
            $worker_price = $worker->currentPrice($report->report_date);
            $price = 0;
            $worker_tax = 0;
            if ($worker_price){
                $price = $worker_price->price;
                $worker_tax = $worker_price->tax;
            }
            $dt->worker_value = $price;
            $dt->worker_tax = $worker_tax;
            $dt->save();
        }
    }

    public function reorder(Request $request) {
        $position = $request->position;
        $arr_replace = array();
        foreach($position as $pos) {
            $worker = Worker::where('position', $pos['oldV'])->first();
            array_push($arr_replace, [$worker->id, $pos['newV']]);
        }
        foreach($arr_replace as $rep) {
            $worker = Worker::find($rep[0]);
            $worker->position = $rep[1];
            $worker->save();
        }
        return $position;
    }
}
