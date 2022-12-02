<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    private $sample=['دوره','فیلم','روزنامه','دفتر','کتاب','سی دی','فلش'];
    public function definition()
    {
        return [
            'title' => Arr::random($this->sample)
        ];
    }
}
