<?php

namespace App\Http\Controllers\Admin;

use App\Functions\TimeCalculator;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\SalesCase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class HomeController extends Controller
{
    public function index()
    {
        $unassignedSalesCasesCount= SalesCase::query()->unassigned()->count();
        $salesCasesCount= SalesCase::query()->count();

        //Today Sum
        $today_sum  = (int) Invoice::query()
            ->whereDate('paid_at', Carbon::today())
            ->approved()
            ->sum('price');

        //Week Sum
        $weekly_sum = (int) Invoice::query()
                ->whereDate('paid_at','>=' , Carbon::today()->subDays(6))
                ->approved()
                ->sum('price');

        //Monthly Sum
        TimeCalculator::getMonthFirstDay();
        $monthly_sum = (int) Invoice::query()
            ->whereDate('paid_at','>=', TimeCalculator::getMonthFirstDay())
            ->approved()
            ->sum('price');


        //Last 10 Invoice
        $invoices   = Invoice::query()->with('user')->orderBy('paid_at' , 'DESC')->take(10)->get();


        // Users Ranking
        $users = User::all();
        $monthFirstDay = TimeCalculator::getMonthFirstDay();
        $ranks = DB::table('invoices')
            ->select(DB::raw('sum(price) as total, user_id'))
            ->where('status' , 'approved')
            ->where('paid_at' , '>' , $monthFirstDay)
            ->groupBy('user_id')
            ->get()->sortByDesc('total')->toArray();
        $ranks = array_values($ranks);

        // Products Ranking
        $products= Product::query()
            ->select('id', 'title')
            ->with('invoices', function ($query) {
                return $query->select('id', 'status')->approved();
        })->get()->toArray();

        foreach ($products as $key => $product)
            $products[$key]['invoices'] = count($product['invoices']);

        $products = collect($products)->sortBy('invoices')->reverse();
        $products = $products->values();

        return view('admin.index')
            ->with(['invoices'              => $invoices])
            ->with(['today_sum'             => $today_sum])
            ->with(['weekly_sum'            => $weekly_sum])
            ->with(['monthly_sum'           => $monthly_sum])
            ->with(['products'              => $products])
            ->with(['users'                 => $users])
            ->with(['unassignedSalesCasesCount'  => $unassignedSalesCasesCount])
            ->with(['salesCasesCount'  => $salesCasesCount])
            ->with(['ranks'                 => $ranks]);
    }
}
