<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        User::factory()->superAdmin()->hasInvoice(250)->create();
        User::factory()->count(10)->hasInvoice(100)->agent()->create();
        Product::factory()->count(10)->create();
    }
}
