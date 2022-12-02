<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleCaseStatusRuleSeeder extends Seeder
{

    public function run()
    {
        foreach ($this->datas() as $data){
            DB::table('sales_case_status_rules')->insert($data);
        }
    }
    private function datas()
    {
        return
            [
                [
                    'from' => 1,
                    'to'   => 2,
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'from' => 2,
                    'to'   => 3,
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];
    }
}
