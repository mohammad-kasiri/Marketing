<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SMS extends Facade
{
    protected static function getFacadeAccessor()
    {
        $sms_panels = [
            "kavenegar"  => \App\Sms\Kavenegar::class,
            "sms_ir"     => \App\Sms\Sms_ir::class,
            "ip_panel"   => \App\Sms\IP_Panel::class,
        ];

        return  $sms_panels[config('sms.default')];
    }
}
