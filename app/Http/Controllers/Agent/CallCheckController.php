<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\CallLog;
use App\Models\Customer;
use Illuminate\Http\Request;

class CallCheckController extends Controller
{
    public function check()
    {
        $log= CallLog::query()
            ->where('created_at' , ">=", now()->subSeconds(4))
            ->where('is_notified', false)
            ->where('event_name' , '=', 'IncomingCall')
            ->where('to' , '=', auth()->user()->voip_number)
            ->latest()
            ->first();

        if (is_null($log))
            return response()->json(["status" => 101],200);


        $customer= Customer::query()
            ->select('id','fullname','mobile')
            ->where('mobile', $log->from)
            ->first();

        if (!is_null($customer))
            $log->is_notified = true;
            $log->save();

            return response()->json([
                'status'  => 100,
                'id'      => $customer->id,
                'name'    => $customer->fullname,
                'mobile'  => $customer->mobile,
            ],200);

        return response()->json(["status" => 101],200);
    }
}
