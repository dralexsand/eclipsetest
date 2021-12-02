<?php

declare(strict_types=1);


namespace App\Helpers;

class Utils
{

    public static function UniqueRandomInt(int $min, int $max, int $quantity): array
    {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }

}
