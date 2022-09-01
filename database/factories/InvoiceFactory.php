<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class InvoiceFactory extends Factory
{
    public function definition()
    {
        return [
            'price'             =>   rand(1 , 9) * 100000,
            'account_number'    =>   rand(1000,9999),
            'description'       =>   $this->faker->text(250),
            'status'            =>   Arr::random(['sent' , 'approved' , 'rejected']),
            'paid_at'           =>   Carbon::today()->subDays(rand(0, 365))
        ];
    }
}
