<?php

namespace App\Calculation;


use App\Entity\InputRecord;
use App\Entity\OutputRecord;

class ComposensationCalculationService
{
    public function __construct(private readonly WorkingDaysInMonthProvider $workingDaysInMonthProvider)
    {

    }

    /**
     * @param int $year
     * @param InputRecord[] $employees
     * @return OutputRecord[]
     */
    public function calculate(int $year, array $employees): array
    {
        $workingDaysPerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $workingDaysPerMonth[] = $this->workingDaysInMonthProvider->getWorkingDays($year, $i);
        }

        $ret = [];
        foreach ($employees as $employee) {
            $compensationPerMonthPerEmployee = [];
            $calculator = $this->getCalculator($employee->getTransportType());
            for ($i = 0; $i < 12; $i++) {

            }
        }
    }


    private function getNumberOfDaysWorked(array $workingDaysInMonth, int $employeeWorkingDays): int
    {
        $daysWorked = 0;
        foreach ($workingDaysInMonth as $workingDay) {
            if ($workingDay->format('N') <= $employeeWorkingDays) {
                $daysWorked++;
            }
        }

        return $daysWorked;
    }

    private function getCalculator(string $transportType): int
    {

    }
}