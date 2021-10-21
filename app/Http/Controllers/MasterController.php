<?php

namespace App\Http\Controllers;

use App\Models\WorkerPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Setting;
use App\Models\Worker;
use App\Models\LeaseCompany;
use App\Models\LeaseType;
use App\Models\LeaseEquipment;
use App\Models\LeaseEquipmentPrice;
use App\Models\Tax;
use DB;

class MasterController extends Controller
{
    public function index(){
        $tax_model = Tax::orderBy('created_at', 'DESC')->first();

        $company = CompanyController::get_company_list_all();

        $taxes = Tax::orderBy('start_date', 'ASC')->get();

        $data = [
            'tax' => $tax_model,
            'company' => $company,
            'taxes' => $taxes,
        ];

        return view('daily.pages.master', $data);
    }

    public function set_excise_info(Request $request) {
        return Tax::create([
            'price' => $request->tax,
            'start_date' => $request->startdate,
        ]);
    }
}
