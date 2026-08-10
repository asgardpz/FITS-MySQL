<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IcBurnOperationsController extends Controller
{
    public function show()
    { 
        return view('IcBurnOperations');
    }

    public function getWorkOrder(Request $request)
    {
        $data = DB::table('ic_burn_operations')
            ->where('work_order', $request->work_order)
            ->first();

        return response()->json([
            'success' => $data ? true : false,
            'data' => $data
        ]);
    }
}
