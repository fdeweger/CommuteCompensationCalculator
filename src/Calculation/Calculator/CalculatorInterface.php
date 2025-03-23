<?php

namespace App\Calculation\Calculator;

interface CalculatorInterface
{
    public function calculate(int $distance, int $daysWorked): int;
}
