<?php

namespace App\Calculation;

interface CalculatorInterface
{
    public function calculate(int $distance, int $daysWorked): int;
}