<?php

namespace App\Calculation;

use App\Calculation\Calculator\BikeCalculator;
use App\Calculation\Calculator\CalculatorInterface;
use App\Calculation\Calculator\FixedKilometerPriceCalculator;
use App\Entity\Employee;
use App\Entity\MonthlyCompensation;
use App\Entity\TotalCompensation;
use App\Entity\TransportType;

class ComposensationCalculationService
{
    public function __construct(private readonly HelperFunctions $helpers)
    {
    }

    /**
     * @param Employee[] $employees
     *
     * @return TotalCompensation[]
     */
    public function calculate(int $year, array $employees): array
    {
        $workingDaysPerMonth = [];
        $dueDates = [];
        for ($i = 1; $i <= 12; ++$i) {
            // Create a list of working days per month
            $workingDaysPerMonth[] = $this->helpers->getWorkingDays($year, $i);
            // And a list of due dates by which the amount must be paid per month
            $dueDates[] = $this->helpers->getDueDate($year, $i);
        }

        $ret = [];
        foreach ($employees as $employee) {
            $compensationPerMonth = [];
            $calculator = $this->getCalculator($employee->getTransportType());
            for ($i = 0; $i < 12; ++$i) {
                // Per employee, per month, get the number of days worked
                $daysWorked = $this->helpers->getNumberOfDaysWorked($workingDaysPerMonth[$i], $employee->getWorkingDays());

                // And calculate the amount due for that month
                $amount = $calculator->calculate($employee->getDistance(), $daysWorked);
                $compensationPerMonth[] = new MonthlyCompensation($employee->getDistance() * $daysWorked * 2, $amount, $dueDates[$i]);
            }

            $ret[] = new TotalCompensation($employee->getName(), $employee->getTransportType(), $compensationPerMonth);
        }

        return $ret;
    }

    private function getCalculator(TransportType $transportType): CalculatorInterface
    {
        switch ($transportType) {
            case TransportType::Bike:
                return new BikeCalculator();
            case TransportType::Bus:
            case TransportType::Train:
                return new FixedKilometerPriceCalculator(25);
            case TransportType::Car:
                return new FixedKilometerPriceCalculator(10);
        }
    }
}
