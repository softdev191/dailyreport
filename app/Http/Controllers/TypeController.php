<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaseType;

class TypeController extends Controller
{
    //
    public function add_type(Request $request) {
        $type = LeaseType::find($request->id);
        if ($type) {
            $type->update([
                "company_id" => $request->company_id,
                "name" => $request->name,
            ]);
        } else {
            LeaseType::create([
                "company_id" => $request->company_id,
                "name" => $request->name,
            ]);
        }
        return 1;
    }

    public function get_type_info(Request $request) {
        $type_detail = LeaseType::get_lease_type_detail($request->id);
        return response()->json($type_detail);
    }

    public function delete_type(Request $request) {
        $type = LeaseType::find($request->id);

        return $type->update(["delete" => 1]);
    }

    public function get_type_list(Request $request) {
        $limit = $request->length;
        $offset = $request->start;
        $company_id = $request->company_id;

        $user = LeaseType::get_lease_type_list($company_id, $limit, $offset);

        $totalFiltered = LeaseType::get_lease_type_list_count($company_id);

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
}
