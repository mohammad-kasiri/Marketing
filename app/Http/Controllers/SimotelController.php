<?php

namespace App\Http\Controllers;

use App\Models\CallLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SimotelController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'event_name'      => ['required', 'in:OutgoingCall,IncomingCall'],
            'number'          => ['required'],
            'unique_id'       => ['required'],
            'cuid'            => ['required'],
        ]);

        if ($request->headers->get('php-auth-user') != 'C%-+e)h?evN70W='&&$request->headers->get('php-auth-pw') != 'lME^ig1zbPolDMu' )
        {
            return response()->json([
                'message' => 'wrong credential'
            ], 401);
        }


        $from= $request->event_name == 'OutgoingCall'
            ?  $request->outgoing_point
            :  $request->number;

        $to=   $request->event_name == 'IncomingCall'
            ?  $request->entry_point
            :  $request->number;

        CallLog::query()->create([
           'event_name' => $request->event_name,
           'from'       => $from,
           'to'         => $to,
           'uid'        => $request->unique_id,
           'cuid'       => $request->cuid,
        ]);

        return response()->json([
            'message' => 'Log has saved successfully'
        ], 201);
    }
}
