<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{

    public function show()
    {
        // 取得最新 KPI
        $latestKpi = DB::table('kpi_daily')
            ->orderByDesc('date')
            ->first();

        $todayOrders = $latestKpi->orders ?? 0;
        $todayOk     = $latestKpi->ok_qty ?? 0;
        $todayNg     = $latestKpi->ng_qty ?? 0;

        // 取得圖表資料
        $chartRows = DB::table('production_chart')
            ->orderBy('date')
            ->get();

        // 把 date 字串轉成 Carbon 再 format
        $chartLabels = $chartRows->map(fn($r) => Carbon::parse($r->date)->format('m/d'))->toArray();

        $chartData = [
            'ng'    => $chartRows->map(fn($r) => $r->ng)->toArray(),
            'ok'    => $chartRows->map(fn($r) => $r->ok)->toArray(),
            'total' => $chartRows->map(fn($r) => $r->total)->toArray(),
            'line'  => $chartRows->map(fn($r) => $r->line)->toArray(),
        ];

        return view('dashboard', compact(
            'todayOrders','todayOk','todayNg',
            'chartLabels','chartData'
        ));
    }

}

