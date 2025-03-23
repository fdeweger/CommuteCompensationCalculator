<?php

namespace App\Calculation;

class FixedKilometerPriceCalculator implements CalculatorInterface
{
    public function __construct(private readonly int $pricePerKilometer)
    {

    }
    public function calculate(int $distance, int $daysWorked): int
    {
        if ($distance < 0) {
            return 0;
        }

        return $distance * 2 * $this->pricePerKilometer * $daysWorked;
    }
}
