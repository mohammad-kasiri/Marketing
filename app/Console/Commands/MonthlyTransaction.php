<?php

namespace App\Console\Commands;

use App\Functions\DateFormatter;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class MonthlyTransaction extends Command
{
    protected $signature = 'month:check';
    protected $description = 'Check To Make Transaction';
    public function handle()
    {
        $monthDayToCheck = 25;

        $day   = (int) Jalalian::now()->getDay();
        $month = (int) Jalalian::now()->getMonth();

        if ($day == $monthDayToCheck)
        {
            $first_user = $this->first_user()->user_id;


            for ($i= 0; $i <= 32; $i++)
            {
                $data = Jalalian::now()->subDays($i);
                if ($data->getDay() == $monthDayToCheck && $data->getMonth() == $month - 1)
                {
                    $array = \Morilog\Jalali\CalendarUtils::toGregorian($data->getYear(), $data->getMonth(), $data->getDay());
                    $month25th = Carbon::create($array[0], $array[1], $array[2], 2, 0, 0);
                    break;
                }
            }

            if(Cache::has('last_monthly_transaction') && Cache::get('last_monthly_transaction') == $month25th)
            {
                return;
            }

            $users = User::query()->agents()->get();

            foreach ($users as $user)
            {
                $total = Invoice::query()
                    ->where('paid_at' , '<=' , now())
                    ->where('paid_at' , '>=' , $month25th)
                    ->where('user_id' , $user->id)
                    ->where('status'  , 'approved')
                    ->sum('price');

                $percentage = $user->id == $first_user
                    ? 8
                    : $user->percentage;

                Transaction::query()->create([
                    'agent_id'       => $user->id,
                    'admin_id'       => 1,
                    'total'          => $total,
                    'percentage'     => ($total/100) * $percentage,
                    'from_date'      => $month25th,
                    'to_date'        => now(),
                    'description'    => 'پرداخت ماهانه',
                ]);

            }
        }

        Cache::forever('last_monthly_transaction', $month25th);

    }

    private function first_user()
    {
        // Ranking  //
        for ($i= 0; $i <= 32; $i++)
        {
            $data = Jalalian::now()->subDays($i);
            if ($data->getDay() == 25)
            {
                $array = \Morilog\Jalali\CalendarUtils::toGregorian($data->getYear(), $data->getMonth(), $data->getDay());
                $month25th = Carbon::create($array[0], $array[1], $array[2], 2, 0, 0);
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

        return $ranks[0];
    }
}
