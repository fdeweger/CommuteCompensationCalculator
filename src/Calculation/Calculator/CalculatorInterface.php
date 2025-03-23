<?php

namespace App\Calculation\Calculator;

interface CalculatorInterface
{
    /**
     * Calculates the amount the employee is due for commute compensations in cents.
     *
     * @param int $distance   Distance in KM for a one way trip
     * @param int $daysWorked Number of days
     *
     * @return int Amnount due in cents
     */
    public function calculate(int $distance, int $daysWorked): int;
}
