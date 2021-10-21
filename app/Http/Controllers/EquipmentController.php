<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaseType;
use App\Models\LeaseEquipment;
use App\Models\LeaseEquipmentPrice;
use App\Models\Report;
use App\Models\ReportDetail;
use App\Models\Tax;

class EquipmentController extends Controller
{
    //
    public function add_equipment(Request $request) {
        $equipment = LeaseEquipment::find($request->id);
        if ($equipment) {
            $equipment->update([
                "name" => $request->name,
                "start_date" => $request->start_date,
            ]);
        } else {
            LeaseEquipment::create([
                "company_id" => $request->company_id,
                "type" => $request->type,
                "name" => $request->name,
                "start_date" => $request->start_date,
            ]);
        }
        return 1;
    }

    public function get_equipment_info(Request $request) {
        $equipment_detail = LeaseEquipment::get_lease_equipment_detail($request->id);
        return response()->json($equipment_detail);
    }

    public function delete_equipment(Request $request) {
        $equipment = LeaseEquipment::find($request->id);

        return $equipment->update(["delete" => 1]);
    }

    public function get_equipment_list(Request $request) {
        $limit = $request->length;
        $offset = $request->start;
        $type = $request->type;
        $company_id = $request->company_id;

        $user = LeaseEquipment::get_lease_equipment_list($type, $company_id, $limit, $offset);

        $totalFiltered = LeaseEquipment::get_lease_equipment_list_count($type, $company_id);

        $return_data = array();

        $index = $offset;

        for ($idx = 0; $idx < count($user); $idx++) {
            $temp = array();

            $index++;
            $temp[0] = $index;
            $temp[1] = $user[$idx]->company_name;
            $temp[2] = $user[$idx]->name;
            $temp[3] = $user[$idx]->id;
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

    public function get_equipment_price_list(Request $request) {
        $limit = $request->length;
        $offset = $request->start;
        $company_id = $request->company_id;
        $type = $request->type;

        $types = LeaseType::get_lease_type_list_all($company_id);
        $equipments = LeaseEquipment::get_lease_equipment_list_all($type, $company_id);

        $data_temp = array();
        for ($i = 0; $i < count($types); $i++) {
            for ($j = 0; $j < count($equipments); $j++) {
                $temp = array();
                $temp[0] = $types[$i]->id;
                $temp[1] = $types[$i]->name;
                $temp[2] = $equipments[$j]->id;
                $temp[3] = $equipments[$j]->name;
                array_push($data_temp, $temp);
            }
        }

        $data = array_slice($data_temp, $offset, $limit);

        $totalFiltered = count($types) * count($equipments);

        $return_data = array();

        $index = $offset;

        for ($idx = 0; $idx < count($data); $idx++) {
            $temp = array();

            $price_model = LeaseEquipmentPrice::where(['equipment_id' => $data[$idx][2], 'type_id' => $data[$idx][0]])->orderBy('start_date', 'DESC')->first();

            $price = 0;
            if ($price_model) $price = $price_model->price;

            $index++;
            $temp[0] = $index;
            $temp[1] = $data[$idx][1];
            $temp[2] = $data[$idx][3];
            $temp[3] = number_format($price);
            $temp[4] = $data[$idx][0];
            $temp[5] = $data[$idx][2];
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

    public function change_equipment_price(Request $request) {
        $type_id = $request->type_id;
        $equip_id = $request->equip_id;
        $price_id = $request->price_id;
        $price = $request->price;
        $startdate = $request->startdate;

        $price_model = LeaseEquipmentPrice::find($price_id);
        if ($price_model) {
            $price_model->update([
                'price' => $price,
                'start_date' => $startdate,
            ]);
        } else {
            LeaseEquipmentPrice::create([
                "type_id" => $type_id,
                "equipment_id" => $equip_id,
                "price" => $price,
                'start_date' => $startdate,
            ]);
        }
        $this->update_price_all($equip_id);
    }

    public function get_type_equip_list(Request $request) {
        $company_id = $request->company_id;

        $type = LeaseType::get_lease_type_list_all($company_id);
        $equipment = LeaseEquipment::get_lease_equipment_list_all(1, $company_id);
        $car = LeaseEquipment::get_lease_equipment_list_all(0, $company_id);
        $data = [
            'type' => $type,
            'equipment' => $equipment,
            'car' => $car,
        ];

        return response() ->json($data);
    }

    public function get_equip_price(Request $request) {
        $type_id = $request->type_id;
        $equip_id = $request->equip_id;
        $date = $request->date;

        $cur_price_model = LeaseEquipmentPrice::where(['equipment_id' => $equip_id, 'type_id' => $type_id])
            ->where('start_date', '<=', $date)
            ->orderBy('start_date', 'DESC')
            ->first();

        $tax_model = Tax::currentTax(date("Y-m-d"));
        $tax = 10;
        if ($tax_model) {
            $tax = $tax_model->price;
        }

        if ($cur_price_model) {
            return round($cur_price_model->price * ($tax + 100) / 100);
        } else {
            $last_price_model = LeaseEquipmentPrice::where(['equipment_id' => $equip_id, 'type_id' => $type_id])
                ->where('created_at', '<=', $date)
                ->orderBy('created_at', 'DESC')
                ->first();
            if ($last_price_model) {
                return round($last_price_model->price * ($tax + 100) / 100);
            } else {
                return 0;
            }
        }
    }

    public function get_equipment_price_list_detail(Request $request) {
        $type_id = $request->type_id;
        $equip_id = $request->equip_id;
        $prices = LeaseEquipmentPrice::where(['equipment_id' => $equip_id, 'type_id' => $type_id])
            ->orderBy('start_date', 'ASC')
            ->get();
        $res = array();
        $totalFiltered = count($prices);
        foreach($prices as $p) {
            array_push($res, [number_format($p->price), $p->start_date, $p->id, $p->equipment_id, $p->type_id]);
        }
        $json_data = array(
            "draw" => intval($request->draw),
            "recordsTotal" => intval($totalFiltered),
            "recordsFiltered" => intval($totalFiltered),
            "memberCnt" => number_format(intval($totalFiltered)),
            "data" => $res,
        );
        return $json_data;
    }

    public function get_equipment_price_one(Request $request) {
        $price = LeaseEquipmentPrice::find($request->id);
        return response()->json($price);
    }

    public function delete_equip_price(Request $request) {
        $price = LeaseEquipmentPrice::find($request->id);
        $equip = LeaseEquipment::find($price->equipment_id);
        $this->update_price_all($equip->id);
        $price->delete();
    }

    public function update_price_all($equip_id) {
        $equip = LeaseEquipment::find($equip_id);
        if ($equip->type == 0) {
            $details = ReportDetail::where('trucks_tool_id', $equip_id)->get();
            foreach($details as $dt) {
                $report = Report::find($dt->report_id);
                $type = $report->trucks_type_id;
                $equip_price = $equip->currentPrice($type, $report->report_date);
                $price = 0;
                if ($equip_price) $price = $equip_price->price;
                $dt->trucks_value = $price;
                $dt->save();
            }
        } else {
            $details = ReportDetail::where('equipment_tool_id', $equip_id)->get();
            foreach($details as $dt) {
                $report = Report::find($dt->report_id);
                $type = $report->equipment_tool_id;
                $equip_price = $equip->currentPrice($type, $report->report_date);
                $price = 0;
                if ($equip_price) $price = $equip_price->price;
                $dt->equipment_value = $price;
                $dt->save();
            }
        }
    }
}
