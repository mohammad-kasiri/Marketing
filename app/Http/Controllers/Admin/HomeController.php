<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class HomeController extends Controller
{
    public function index()
    {
        $invoices   = Invoice::query()->with('user')->latest()->take(10)->get();
        $today_sum  = (int) Invoice::query()->whereDay('created_at', Carbon::today())->sum('price');

        //GET SALE AMOUNT FOR EACH DAY
        $sale = [];
        for ($i = 6; $i>=0; $i--)
            $sale[] = (int) Invoice::query()
                ->whereDay('created_at', Carbon::today()->subDays($i))
                ->sum('price');

        $weekly_sum  = array_sum($sale);

        //GET SALE AMOUNT FOR EACH DAY
        $sale = [];
        for ($i = 11; $i>=0; $i--)
            $sale[] = (int) Invoice::query()
                ->whereMonth('created_at', Carbon::today()->subMonth($i))
                ->sum('price');

        $monthly_sum = array_sum($sale);


        return view('admin.index')
            ->with(['invoices'    => $invoices])
            ->with(['today_sum'   => $today_sum])
            ->with(['weekly_sum'  => $weekly_sum])
            ->with(['monthly_sum' => $monthly_sum]);

    }
}
