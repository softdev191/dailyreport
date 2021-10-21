<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportDetail;
use Illuminate\Http\Request;
use App\Models\Tax;
use App\Models\Spot;

class TaxController extends Controller
{
    //
    public function set_excise_info(Request $request) {
        Tax::create([
            'price' => $request->tax,
            'start_date' => $request->startdate,
        ]);
        $this->update_tax_all();
        return $this->get_taxes_list();
    }
    public function get_taxes_list() {
        $taxes = Tax::orderBy('start_date', 'ASC')->get();
        return view('daily.layout.tax')->with(compact('taxes'));
    }
    public function delete_tax($id) {
        Tax::find($id)->delete();
        $this->update_tax_all();
        return $this->get_taxes_list();
    }
    public function update_tax(Request $request)  {
        Tax::find($request->id)->update([
            'price' => $request->tax,
            'start_date' => $request->startdate,
        ]);
        $this->update_tax_all();
        return $this->get_taxes_list();
    }
    public function update_tax_all() {
        $spots = Spot::where('tax', '>', 0)->get();
        foreach($spots as $spot) {
            $tax = Tax::currentTax(date_format(date_create($spot->created_at),"Y-m-d"));
            $price = 10;
            if ($tax) $price = $tax->price;
            $spot->update(['tax' => $price]);
        }
        $report_details = ReportDetail::where('tax', '>', 0)->get();
        foreach($report_details as $rd) {
            $report = Report::find($rd->report_id);
            $tax = Tax::currentTax($report->report_date);
            $price = 10;
            if ($tax) $price = $tax->price;
            $spot->update(['tax' => $price]);
        }
    }
}
