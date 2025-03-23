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
    public function __construct(private readonly WorkingDaysInMonthProvider $workingDaysInMonthProvider)
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
            $workingDaysPerMonth[] = $this->workingDaysInMonthProvider->getWorkingDays($year, $i);
            $dueDates[] = $this->workingDaysInMonthProvider->getDueDate($year, $i);
        }

        $ret = [];
        foreach ($employees as $employee) {
            $compensationPerMonthPerEmployee = [];
            $calculator = $this->getCalculator($employee->getTransportType());
            for ($i = 0; $i < 12; ++$i) {
                $daysWorked = $this->workingDaysInMonthProvider->getNumberOfDaysWorked($workingDaysPerMonth[$i], $employee->getWorkingDays());
                $amount = $calculator->calculate($employee->getDistance(), $daysWorked);
                $compensationPerMonthPerEmployee[] = new MonthlyCompensation($employee->getDistance() * $daysWorked * 2, $amount, $dueDates[$i]);
            }

            $ret[] = new TotalCompensation($employee->getName(), $employee->getTransportType(), $compensationPerMonthPerEmployee);
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
