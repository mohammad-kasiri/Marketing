<?php

namespace App\Functions;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

class TimeCalculator
{
    const MONTH_FIRST_DAY= 26;

    public static function getMonthFirstDay()
    {
        if(Jalalian::now()->getDay() == static::MONTH_FIRST_DAY) {
            $array = CalendarUtils::toGregorian(Jalalian::now()->getYear(), Jalalian::now()->getMonth(), Jalalian::now()->getDay());
            return Carbon::create($array[0], $array[1], $array[2], 2, 0, 0);
        }

       for ($i= 1; $i <= 32; $i++)
       {
           $date = Jalalian::now()->subDays($i);
           if ($date->getDay() == static::MONTH_FIRST_DAY)
           {
               $array = CalendarUtils::toGregorian($date->getYear(), $date->getMonth(), $date->getDay());
               return Carbon::create($array[0], $array[1], $array[2], 2, 0, 0);
           }
       }
    }

    public static function getFirstUserId()
    {
        $monthFirstDay= static::getMonthFirstDay();

        $ranks = DB::table('invoices')
            ->select(DB::raw('sum(price) as total, user_id'))
            ->where('status' , 'approved')
            ->where('paid_at' , '>' , $monthFirstDay)
            ->groupBy('user_id')
            ->get()->sortByDesc('total')->toArray();

        $ranks = array_values($ranks);

        return $ranks[0]->user_id;
    }

    public static function isTodayFirstDayOfTheMonth() {
        return (int) Jalalian::now()->getDay() == static::MONTH_FIRST_DAY;
    }
}
