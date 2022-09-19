<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class HomeController extends Controller
{
    public function index()
    {
        $invoices   = Invoice::query()->where('user_id' , auth()->id())->latest()->take(10)->get();

        $ranking = Cache::has('Setting_Ranking') ? Cache::get('Setting_Ranking') : false;

        $today_sum  = (int) Invoice::query()
                                    ->where('user_id' , auth()->id())
                                    ->whereDay('paid_at', Carbon::today())
                                    ->sum('price');

        //GET SALE AMOUNT FOR EACH DAY
        $sale = [];
        for ($i = 6; $i>=0; $i--)
            $sale[] = (int) Invoice::query()
                ->where('user_id' , auth()->id())
                ->whereDay('paid_at', Carbon::today()->subDays($i))
                ->sum('price');

        $weekly_sum  = array_sum($sale);

        //GET SALE AMOUNT FOR EACH DAY
        $sale = [];
        for ($i = 11; $i>=0; $i--)
            $sale[] = (int) Invoice::query()
                ->where('user_id' , auth()->id())
                ->whereMonth('paid_at', Carbon::today()->subMonth($i))
                ->sum('price');

        $monthly_sum = array_sum($sale);

        // Ranking  //
        for ($i= 0; $i <= 32; $i++)
        {
            $data = Jalalian::now()->subDays($i);
            if ($data->getDay() == 25)
            {
                $array = \Morilog\Jalali\CalendarUtils::toGregorian($data->getYear(), $data->getMonth(), $data->getDay());
                $month25th = Carbon::create($array[0], $array[1], $array[2], 0, 0, 0);
            }
        }

        $users = User::all();

        $ranks = DB::table('invoices')
            ->select(DB::raw('sum(price) as total, user_id'))
            ->where('status' , 'approved')
            ->where('paid_at' , '>' , $month25th)
            ->groupBy('user_id')
            ->get()->sortByDesc('total')->toArray();

        $ranks = array_values($ranks);

        return view('agent.index')
            ->with(['invoices'    => $invoices])
            ->with(['today_sum'   => $today_sum])
            ->with(['weekly_sum'  => $weekly_sum])
            ->with(['monthly_sum' => $monthly_sum])
            ->with(['users'       => $users])
            ->with(['ranking'     => $ranking])
            ->with(['ranks'       => $ranks]);;

    }

}
