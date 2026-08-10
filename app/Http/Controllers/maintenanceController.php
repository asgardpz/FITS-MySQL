<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class maintenanceController extends Controller
{
    public function show()
    {
        
        // 直接用 $_GET 取值，不用 Request
        $startDate = $_GET['startDate'] ?? null;
        $endDate   = $_GET['endDate'] ?? null;

        // 如果沒傳，預設三個月
        if (!$startDate || !$endDate) {
            $endDate   = now()->addDay(); // 改成「今天 +1 天」;
            $startDate = now()->subMonths(3);
        }

        $work_orders = DB::table('ic_work_orders')
            ->select(
                'work_order_code',
                'start_date',
                'part_number',
                'work_order_qty',
                'stock_qty',
                'status',
                'completion_date',
                'model'
            )
            ->whereBetween('start_date', [$startDate, $endDate])
            ->orderBy('start_date', 'desc')
            ->get();


        return view('maintenance', compact(
            'work_orders'
        ));
    }
}
