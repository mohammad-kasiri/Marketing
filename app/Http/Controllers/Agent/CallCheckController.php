<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\CallLog;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CallCheckController extends Controller
{
    public function check()
    {
       if (! Cache::has(auth()->user()->voip_number)) {
           return response()->json(["status" => 101],200);
       }


       $data=  Cache::get(auth()->user()->voip_number);
       $data= json_decode($data);

       $log= CallLog::query()->find($data->call_log);
       $log->is_notified = true;
       $log->save();

        Cache::forget(auth()->user()->voip_number);

        return response()->json($data,200);
    }
}
