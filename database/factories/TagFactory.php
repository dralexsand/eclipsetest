<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $array = [1, 2, 3, 4, 5];
        $random = Arr::random($array);

        return [
            'name' =>
                strtolower($this->faker->firstName())
                . strtolower($this->faker->lastName())
                . strtolower(Str::random(random_int(10, 40))),
            //'name' => strtolower(Str::random(random_int(10, 40))),
        ];
    }
}
