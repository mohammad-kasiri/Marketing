<?php

namespace App\Sms;

class SMS
{
    public static function for($number)
    {
        return new Kavenegar($number);
    }
}
