<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realTextBetween(10, 50)
                . strtolower(Str::random(random_int(5, 20))),
            'content' => $this
                    ->faker
                    ->realTextBetween(200, 500, random_int(2, 5))
                . strtolower(Str::random(random_int(10, 40))),
        ];
    }
}
