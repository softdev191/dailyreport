<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaseCompany;

class CompanyController extends Controller
{
    public function add_company(Request $request) {
        $company = LeaseCompany::find($request->id);
        if ($company) {
            $company->update([
                "name" => $request->name,
            ]);
        } else {
            LeaseCompany::create([
                "name" => $request->name,
            ]);
        }
        return response()->json(static::get_company_list_all());
    }

    public function get_company_info(Request $request) {
        return response()->json(LeaseCompany::find($request->id));
    }

    public function delete_company(Request $request) {
        $company = LeaseCompany::find($request->id);

        $company->update(["delete" => 1]);

        return response()->json(static::get_company_list_all());
    }

    public function get_company_list(Request $request) {
        $limit = $request->length;
        $offset = $request->start;

        $user = LeaseCompany::where(['delete' => 0])
            ->orderBy('created_at', 'DESC')
            ->skip($offset)->take($limit)
            ->get();

        $totalFiltered = count(LeaseCompany::where(['delete' => 0])->get());

        $return_data = array();

        $index = $offset;

        for ($idx = 0; $idx < count($user); $idx++) {
            $temp = array();

            $index++;
            $temp[0] = $index;
            $temp[1] = $user[$idx]->name;
            $temp[2] = $user[$idx]->id;
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

    public static function get_company_list_all() {
        return LeaseCompany::where(['delete' => 0])->orderBy('created_at', 'DESC')->get();
    }
}
