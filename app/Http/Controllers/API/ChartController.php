<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class ChartController extends Controller
{
    public function agentWeekly(Request $request)
    {
        // GET LAST 7 DAYS
        $days = [];
        for($i = 6; $i>=0; $i-- )
            $days[] = Carbon::today()->subDays($i);

        //GET SALE AMOUNT FOR EACH DAY
        $sale = [];

        foreach ($days as $day)
            $sale[] = (int) Invoice::query()
                ->whereDay('paid_at', $day)
                ->where('user_id' , $request->agent)
                ->where('status' , 'approved')
                ->sum('price');


        $days = array_map(function ($day){
            return Jalalian::forge($day)->format('%A, %d %B %Y');
        },$days );

        return response()->json([
                'days'  => $days,
                'sale'  => $sale,
                'total' => array_sum($sale)
            ]);
    }

    public function agentMonthly(Request $request)
    {
        // GET LAST 7 DAYS
        $days = [];
        for($i = 11; $i>=0; $i-- )
            $days[] = Carbon::today()->subMonth($i);

        //GET SALE AMOUNT FOR EACH DAY
        $sale = [];

        foreach ($days as $day)
            $sale[] = (int) Invoice::query()
                ->whereMonth('paid_at', $day)
                ->where('user_id' , $request->agent)
                ->where('status' , 'approved')
                ->sum('price');


        $days = array_map(function ($day){
            return Jalalian::forge($day)->format(' %B %Y');
        },$days );

        return response()->json([
            'days'  => $days,
            'sale'  => $sale,
            'total' => array_sum($sale)
        ]);
    }

    public function weekly(Request $request)
    {
        // GET LAST 7 DAYS
        $days = [];
        for($i = 6; $i>=0; $i-- )
            $days[] = Carbon::today()->subDays($i);

        //GET SALE AMOUNT FOR EACH DAY
        $sale = [];

        foreach ($days as $day)
            $sale[] = (int) Invoice::query()
                ->whereDay('paid_at', $day)
                ->where('status' , 'approved')
                ->sum('price');


        $days = array_map(function ($day){
            return Jalalian::forge($day)->format('%A, %d %B %Y');
        },$days );

        return response()->json([
            'days'  => $days,
            'sale'  => $sale,
            'total' => array_sum($sale)
        ]);
    }

    public function monthly(Request $request)
    {
        // GET LAST 7 DAYS
        $days = [];
        for($i = 11; $i>=0; $i-- )
            $days[] = Carbon::today()->subMonth($i);

        //GET SALE AMOUNT FOR EACH DAY
        $sale = [];

        foreach ($days as $day)
            $sale[] = (int) Invoice::query()
                ->whereMonth('paid_at', $day)
                ->where('status' , 'approved')
                ->sum('price');


        $days = array_map(function ($day){
            return Jalalian::forge($day)->format(' %B %Y');
        },$days );

        return response()->json([
            'days'  => $days,
            'sale'  => $sale,
            'total' => array_sum($sale)
        ]);
    }
}
