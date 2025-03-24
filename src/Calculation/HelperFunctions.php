<?php

namespace App\Calculation;

class HelperFunctions
{
    private array $publicHolidays = [];

    public function __construct(array $publicHolidays)
    {
        foreach ($publicHolidays as $publicHoliday) {
            $this->publicHolidays[] = new \DateTimeImmutable($publicHoliday);
        }
    }

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
            // Filter out public holidays
            if (false === in_array($startDate, $this->publicHolidays)) {
                // filter out saturday & sunday
                if ($startDate->format('N') < 6) {
                    $workingDays[] = $startDate;
                }
            }

            $startDate = $startDate->add(new \DateInterval('P1D'));
        }

        return $workingDays;
    }

    public function getNumberOfDaysWorked(array $workingDaysInMonth, array $employeeWorkingDays): int
    {
        $daysWorked = 0;
        foreach ($workingDaysInMonth as $workingDay) {
            if (in_array($workingDay->format('N'), $employeeWorkingDays)) {
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
