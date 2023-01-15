<?php

namespace App\Console\Commands;

use App\Models\SalesCase;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class DistributorCommand extends Command
{
    protected $signature = 'share:case';

    protected $description = 'by This Command You Can Fetch All Unallocated Cases To Agents';

    public function handle()
    {
        $agents= User::query()->agents()->active()->get();
        $unassignedCases= SalesCase::query()->unassigned()->get();
        if (Cache::has("Setting_SplitCount") && Cache::get("Setting_SplitCount") > 0) {
            $count=  Cache::get("Setting_SplitCount");
            if ( (count($agents) * $count )  < count($unassignedCases))
            {
                foreach ($agents as $agent)
                {
                    $cases = SalesCase::query()->unassigned()->join('sales_case_tags', 'sales_cases.tag_id', '=', 'sales_case_tags.id')
                        ->orderBy('sales_case_tags.sort', 'ASC')
                        ->take((int)$count)->get();

                    foreach ($cases as $case){
                        $case->agent_id = $agent->id;
                        $case->save();
                    }
                }
            }else{
                $c= count($unassignedCases) / count($agents);
                foreach ($agents as $agent)
                {
                    $cases= SalesCase::query()->unassigned()->take((int)$c)->get();
                    foreach ($cases as $case){
                        $case->agent_id = $agent->id;
                        $case->save();
                    }
                }
            }
        }
    }
}
