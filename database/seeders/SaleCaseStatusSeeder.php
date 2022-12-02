<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleCaseStatusSeeder extends Seeder
{

    public function run()
    {
        foreach ($this->datas() as $data){
            DB::table('sales_case_statuses')->insert($data);
        }
    }
    private function datas()
    {
        return
            [
                [
                    'name' => 'ایجاد شد',
                    'is_active' => true,
                    'is_first_step' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'اولین تماس گرفته شد',
                    'is_active' => true,
                    'is_first_step' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'یادآوری انجام شد',
                    'is_active' => true,
                    'is_first_step' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'یادآوری دوم انجام شد',
                    'is_active' => true,
                    'is_first_step' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ];
    }
}
