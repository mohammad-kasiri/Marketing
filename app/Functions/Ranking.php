<?php

namespace App\Functions;

use Illuminate\Support\Facades\DB;

class Ranking
{
    const TOPSELLER_PRECENTAGE=8;

    public static function get(){

        config()->set('database.connections.mysql.strict', false);
        \DB::reconnect();

        $ranking= DB::table('invoices')
            ->select(
                DB::raw('sum(invoices.price) as total, users.id') ,
                DB::raw('concat(users.first_name," ", users.last_name) as fullName'),
                'users.percentage'
            )
            ->leftJoin('users', 'invoices.user_id', '=', 'users.id')
            ->where('invoices.paid_at' , '>=' , TimeCalculator::getMonthFirstDay())
            ->where('invoices.status' , '=' , 'approved')
            ->where('users.level' , '=' , 'agent')
            ->groupBy('users.id')
            ->orderBy('total', 'DESC')
            ->get();

        config()->set('database.connections.mysql.strict', true);
        \DB::reconnect();

        return $ranking;
    }
}
