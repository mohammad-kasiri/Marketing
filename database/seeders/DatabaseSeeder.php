<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(ProvinceSeeder::class);
        $this->call(FailureReasonSeeder::class);
        $this->call(SaleCaseStatusSeeder::class);
        $this->call(SaleCaseStatusRuleSeeder::class);
        User::factory()->superAdmin()->hasInvoice(250)->create();
        User::factory()->count(10)->hasInvoice(100)->agent()->create();
        Product::factory()->count(10)->create();
        Customer::factory()->count(10)->create();
    }
}
