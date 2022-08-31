<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $invoices   = Invoice::query()->where('user_id' , auth()->id())->latest()->take(10)->get();

        $today_sum  = (int) Invoice::query()
                                    ->where('user_id' , auth()->id())
                                    ->whereDay('created_at', Carbon::today())
                                    ->sum('price');

        //GET SALE AMOUNT FOR EACH DAY
        $sale = [];
        for ($i = 6; $i>=0; $i--)
            $sale[] = (int) Invoice::query()
                ->where('user_id' , auth()->id())
                ->whereDay('created_at', Carbon::today()->subDays($i))
                ->sum('price');

        $weekly_sum  = array_sum($sale);

        //GET SALE AMOUNT FOR EACH DAY
        $sale = [];
        for ($i = 11; $i>=0; $i--)
            $sale[] = (int) Invoice::query()
                ->where('user_id' , auth()->id())
                ->whereMonth('created_at', Carbon::today()->subMonth($i))
                ->sum('price');

        $monthly_sum = array_sum($sale);


        return view('agent.index')
            ->with(['invoices'    => $invoices])
            ->with(['today_sum'   => $today_sum])
            ->with(['weekly_sum'  => $weekly_sum])
            ->with(['monthly_sum' => $monthly_sum]);


    }

}
