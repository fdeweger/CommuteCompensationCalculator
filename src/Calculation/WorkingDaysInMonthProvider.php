<?php

namespace App\Calculation;

class WorkingDaysInMonthProvider
{
    public function getWorkingDays(int $year, int $month): array
    {
        $startDate = new \DateTimeImmutable($year . '-' . $month . '-01');
        $endDate = $startDate->add(new \DateInterval('P1M'));
        $workingDays = [];

        while ($startDate < $endDate) {
            if ($startDate->format('N') < 6) {
                $workingDays[] = $startDate;
            }

            $startDate = $startDate->add(new \DateInterval('P1D'));
        }

            //echo $startDate->format('Y-m-d N') . PHP_EOL;


        return $workingDays;
    }
}