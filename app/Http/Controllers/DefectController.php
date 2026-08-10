<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DefectController extends Controller
{
    public function show()
    {
        $startDate = request('start_date') ?? now()->subMonths(3)->format('Y-m-d');
        $endDate   = request('end_date') ?? now()->format('Y-m-d');

        // 工單資料
        $work_orders = DB::table('ic_work_orders')
            ->select('work_order_code','start_date','part_number','work_order_qty','stock_qty','status','completion_date','model')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->orderBy('start_date','desc')
            ->get();

        // 測試良率追蹤 (取 ic_burn_records 的良率與數量)
        $yield_records = DB::table('ic_burn_records')
            ->select('production_date','work_order_no','order_qty','yield_rate')
            ->whereBetween('production_date', [$startDate, $endDate])
            ->orderBy('production_date','asc')
            ->get();

        // 不良原因統計
        $defects = DB::table('ic_defects')
            ->select('defect_type', DB::raw('SUM(defect_count) as count'))
            ->whereBetween('production_date', [$startDate, $endDate])
            ->groupBy('defect_type')
            ->get();

        // 不良位置統計
        $positions = DB::table('ic_defects')
            ->select('defect_position', DB::raw('SUM(defect_count) as count'))
            ->whereBetween('production_date', [$startDate, $endDate])
            ->groupBy('defect_position')
            ->get();

        return view('Defect', compact('work_orders','yield_records','defects','positions'));
    }
}
