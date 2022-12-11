<?php

namespace App\Console\Commands;

use App\Models\SalesCase;
use App\Models\SalesCaseStatus;
use App\Models\User;
use App\Sms\SMS;
use Illuminate\Console\Command;

class NotifyAdmin extends Command
{
    protected $signature = 'notify:admin';
    protected $description = 'Distribute SalesCase And Notify Admin When There is not ';

    public function handle()
    {
        $unassignedSalesCases = SalesCase::query()->where('agent_id', '=', null)->count();

        if ($unassignedSalesCases <= 10){
            $admin= User::query()->find(2);
            SMS::for($admin->mobile)->send(' تعداد کمی پرونده باقی مانده است. پرونده های جدید ایجاد کنید.');
            return true;
        }

        $firstStatus= SalesCaseStatus::query()->where('is_first_step', true)->first();
        $agents= User::query()->agents()->active()->get();
        foreach ($agents as $agent)
        {
            $unprocessedSalesCases= SalesCase::query()
                ->where('agent_id', $agent->id)
                ->where('status_id', $firstStatus->id)->count();

            if ($unprocessedSalesCases <= 2)
                $cases= SalesCase::query()->unassigned()->take(5)->get();
                if ($cases)
                {
                    foreach ($cases as $case){
                        $case->agent_id = $agent->id;
                        $case->save();
                    }
                }
        }
    }
}
