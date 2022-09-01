<?php

namespace App\Functions;

use Carbon\Carbon;
use Morilog\Jalali\CalendarUtils;

class DateFormatter
{

    public static function format($date , $time)
    {
        $date = explode("/" ,$date);
        $time= explode(":" ,$time);
        $date=  CalendarUtils::toGregorian($date[0] , $date[1] , $date[2]);
        $date=  Carbon::create($date[0], $date[1] , $date[2] , $time[0] , $time[1]);
        return $date;
    }

}
