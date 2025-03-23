<?php

namespace App\Calculation;

class HelperFunctions
{
    /**
     * Returns a list of dates with al working days (monday to friday) for a given month / year.
     *
     * @return \DateTimeInterface[]
     *
     * @throws \DateMalformedStringException
     */
    public function getWorkingDays(int $year, int $month): array
    {
        $startDate = new \DateTimeImmutable($year.'-'.$month.'-01');
        $endDate = $startDate->add(new \DateInterval('P1M'));
        $workingDays = [];

        while ($startDate < $endDate) {
            if ($startDate->format('N') < 6) {
                $workingDays[] = $startDate;
            }

            $startDate = $startDate->add(new \DateInterval('P1D'));
        }

        return $workingDays;
    }

    public function getNumberOfDaysWorked(array $workingDaysInMonth, int $employeeWorkingDays): int
    {
        $daysWorked = 0;
        foreach ($workingDaysInMonth as $workingDay) {
            if ($workingDay->format('N') <= $employeeWorkingDays) {
                ++$daysWorked;
            }
        }

        return $daysWorked;
    }

    public function getDueDate(int $year, int $month): \DateTimeInterface
    {
        $date = new \DateTimeImmutable($year.'-'.$month.'-01');
        $dueDate = $date->add(new \DateInterval('P1M'));
        while (1 !== (int) $dueDate->format('N')) {
            $dueDate = $dueDate->add(new \DateInterval('P1D'));
        }

        return $dueDate;
    }
}
