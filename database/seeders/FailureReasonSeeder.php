<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FailureReasonSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->datas() as $data){
            DB::table('failure_reasons')->insert($data);
        }
    }

    private function datas()
    {
        return
            [
                [
                    'title' => 'سایر دلایل',
                    'is_deletable' => false
                ]
            ];
    }
}
