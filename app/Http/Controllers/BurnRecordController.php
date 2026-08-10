<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BurnRecordController extends Controller
{
    public function show()
    {
        // 直接用 $_GET 取值，不用 Request
        $startDate = $_GET['startDate'] ?? null;
        $endDate = $_GET['endDate'] ?? null;

        // 如果沒傳，預設三個月
        if (!$startDate || !$endDate) {
            $endDate = now()->addDay(); // 改成「今天 +1 天」
            $startDate = now()->subMonths(3);
        }

        $records = DB::table('ic_burn_records')
            ->select(
                'work_order_no',
                'production_date',
                'part_no',
                'order_qty',
                'good_qty',
                'ng_qty',
                'yield_rate',
                'uph',
                'model',
                'jig_no',
                'status',
                'start_time',
                'end_time',
                'hours'
            )
            ->whereBetween('production_date', [$startDate, $endDate])
            ->orderBy('production_date', 'desc')
            ->get();

        return view('BurnRecord', compact('records'));
    }
}
