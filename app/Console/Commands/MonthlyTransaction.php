<?php

namespace App\Console\Commands;

use App\Functions\DateFormatter;
use App\Functions\TimeCalculator;
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
        if (!TimeCalculator::isTodayFirstDayOfTheMonth())
            return null;

        $topSellerUserId =  TimeCalculator::getFirstUserId();
        $monthFirstDay   =  TimeCalculator::getMonthFirstDay();
        $users           =  User::query()->agents()->active()->get();

        foreach ($users as $user)
        {
            $total = Invoice::query()
                ->where('user_id' , $user->id)
                ->where('paid_at' , '>=' , $monthFirstDay)
                ->where('paid_at' , '<=' , now())
                ->approved()
                ->sum('price');

            $percentage = $user->id == $topSellerUserId
                ? 8
                : $user->percentage;

            Transaction::query()->create([
                'agent_id'       => $user->id,
                'admin_id'       => 1,
                'total'          => $total,
                'percentage'     => ($total/100) * $percentage,
                'from_date'      => $monthFirstDay,
                'to_date'        => now(),
                'description'    => 'پرداخت ماهانه',
            ]);
        }

    }


}
