<?php

namespace App\Http\Controllers;

use App\Models\CallLog;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class SimotelController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'event_name'      => ['required', 'in:OutgoingCall,IncomingCall,NewState'],
        ]);

        if ($request->headers->get('php-auth-user') != 'C%-+e)h?evN70W='&&$request->headers->get('php-auth-pw') != 'lME^ig1zbPolDMu' )
        {
            return response()->json([
                'message' => 'wrong credential'
            ], 401);
        }


        if ($request->event_name == 'OutgoingCall'){
            $from= $request->outgoing_point;
            $to  = $request->number;
            $log= CallLog::query()->create([
                'event_name' => $request->event_name,
                'from'       => $from,
                'to'         => $to,
                'uid'        => $request->unique_id,
                'cuid'       => $request->cuid,
            ]);
        }

        if ($request->event_name == 'NewState' && $request->has('state') && $request->state == 'Ringing')
        {
            $users= User::query()->select('id', 'voip_number')->get();
            $to = null;
            foreach ($users as $user){
                if (Str::endsWith($user->voip_number, $request->exten)){
                    $to=$user->voip_number;
                }
            }

            $from= $request->participant;;
            $log= CallLog::query()->create([
                'event_name' => 'IncomingCall',
                'from'       => $from,
                'to'         => $to,
                'uid'        => $request->unique_id,
                'cuid'       => $request->cuid,
            ]);

            $customer= Customer::query()
                ->select('id','fullname','mobile')
                ->where('mobile', $log->from)
                ->first();

            if ($customer) {
                $response=[
                    'status'  => 100,
                    'call_log'=> $log->id,
                    'id'      => $customer->id,
                    'name'    => $customer->fullname,
                    'mobile'  => $customer->mobile,
                ];

                Cache::put($log->to, json_encode($response),30);
            }
        }


        return response()->json([
            'message' => 'Log has saved successfully'
        ], 201);
    }
}
