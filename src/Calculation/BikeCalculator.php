<?php

namespace App\Calculation;

class BikeCalculator implements CalculatorInterface
{
    public function calculate(int $distance, int $daysWorked): int
    {
        if ($distance < 0 || $distance > 10) {
            return 0;
        }

        $amountPerKilometer = $distance < 5 ? 50 : 100;

        return $distance * 2 * $amountPerKilometer * $daysWorked;
    }
}