<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IcWorkDetailController extends Controller
{
    public function show()
    { 
        return view('IcWorkDetail');
    }

    public function getWorkOrder(Request $request)
    {
        $data = DB::table('ic_work_detail')
            ->where('work_order_no', $request->work_order_no)
            ->first();

        return response()->json([
            'success' => $data ? true : false,
            'data' => $data
        ]);
    }

}
