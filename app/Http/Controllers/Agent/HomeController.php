<?php

namespace App\Http\Controllers\Agent;

use App\Functions\TimeCalculator;
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

        //Today Sum
        $today_sum  = (int) Invoice::query()
            ->where('user_id' , auth()->id())
            ->whereDate('paid_at', Carbon::today())
            ->approved()
            ->sum('price');

        //Week Sum
        $weekly_sum = (int) Invoice::query()
            ->where('user_id' , auth()->id())
            ->whereDate('paid_at','>=' , Carbon::today()->subDays(6))
            ->approved()
            ->sum('price');

        //Monthly Sum
        $monthly_sum = (int) Invoice::query()
            ->where('user_id' , auth()->id())
            ->whereDate('paid_at','>=', TimeCalculator::getMonthFirstDay())
            ->approved()
            ->sum('price');

        // Users Ranking
        $users = User::query()->active()->get();
        $monthFirstDay = TimeCalculator::getMonthFirstDay();
        $ranks = DB::table('invoices')
            ->select(DB::raw('sum(price) as total, user_id'))
            ->where('status' , 'approved')
            ->where('paid_at' , '>' , $monthFirstDay)
            ->where('deleted_at' , '=',null)
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
            ->with(['ranks'       => $ranks]);

    }

}
