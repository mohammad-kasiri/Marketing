<?php

namespace App\Functions;

use Illuminate\Support\Str;

class Phone
{
    public static function convertPersianNumbersToEnglish($phone)
    {
        $phone= Str::replace('۰', '0', $phone);
        $phone= Str::replace('۱', '1', $phone);
        $phone= Str::replace('۲', '2', $phone);
        $phone= Str::replace('۳', '3', $phone);
        $phone= Str::replace('۴', '4', $phone);
        $phone= Str::replace('۵', '5', $phone);
        $phone= Str::replace('۶', '6', $phone);
        $phone= Str::replace('۷', '7', $phone);
        $phone= Str::replace('۸', '8', $phone);
        $phone= Str::replace('۹', '9', $phone);
        $phone= Str::replace('+', '+', $phone);
        return $phone;
    }
}
