<?php
namespace App\Http\Services;
use DB;
use App\Models\Spot;
use App\Models\Report;
use App\Models\ReportDetail;

class ReportService {
    public static function report_one($reportId) {
        $worker_cnt = ReportDetail::where('report_id', $reportId)->where('worker_type', 0)->count();
        $worker_sum = ReportDetail::where('report_id', $reportId)->where('worker_type', 0)->sum(DB::raw('worker_value * percentage'));
        $lancer_cnt = ReportDetail::where('report_id', $reportId)->where('worker_type', 1)->count();
        $lancer_sum = ReportDetail::where('report_id', $reportId)
            ->where('worker_type', 1)
            ->sum(DB::raw('worker_value * (100 + tax * worker_tax) / 100 * percentage'));
        $truck_sum = ReportDetail::where('report_id', $reportId)->sum(DB::raw('trucks_value * (100 + tax) / 100'));
        $equip_sum = ReportDetail::where('report_id', $reportId)->sum(DB::raw('equipment_value * (100 + tax) / 100'));
        $dispose_sum = ReportDetail::where('report_id', $reportId)->sum('disposal_value');
        $expose_sum = ReportDetail::where('report_id', $reportId)->sum('defense_value');
        $etc_sum = ReportDetail::where('report_id', $reportId)->sum('etc_value');
        $total_sum = $worker_sum + $lancer_sum + $truck_sum + $equip_sum + $dispose_sum + $expose_sum + $etc_sum;
        return [
            'worker' => [
                'count' => $worker_cnt,
                'sum' => $worker_sum,
            ],
            'lancer' => [
                'count' => $lancer_cnt,
                'sum' => $lancer_sum,
            ],
            'equip' => [
                'equip' => $equip_sum,
                'truck' => $truck_sum,
            ],
            'extra' => [
                'dispose' => $dispose_sum,
                'expose' => $expose_sum,
                'etc' => $etc_sum,
            ],
            'total' => $total_sum,
        ];
    }
    public static function report_spot($spotId) {
        $reports = Report::where('spot_id', $spotId)->get();
        $worker_cnt = 0;
        $worker_sum = 0;
        $equip_sum = 0;
        $total_sum = 0;
        foreach($reports as $r) {
            $stat = static::report_one($r->id);
            $worker_cnt += $stat['worker']['count'] + $stat['lancer']['count'];
            $worker_sum += $stat['worker']['sum'] + $stat['lancer']['sum'];
            $equip_sum += $stat['equip']['equip'] + $stat['equip']['truck'];
            $total_sum += $stat['total'];
        }
        $spot = Spot::find($spotId);
        $profit = $spot->contract_price == 0 ? 0 : $spot->contract_price - $total_sum;
        $profit_rate = $spot->contract_price == 0 ? 0 : $profit / $spot->contract_price * 100;
        return compact("worker_cnt", "worker_sum", "equip_sum", "total_sum", "profit", "profit_rate");
    }
}
