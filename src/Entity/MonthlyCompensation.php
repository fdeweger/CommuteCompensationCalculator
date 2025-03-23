<?php

namespace App\Entity;

class MonthlyCompensation
{
    public function __construct(private readonly int $totalDistance, private readonly int $compensation, private readonly \DateTimeInterface $dueDate)
    {
    }

    public function getTotalDistance(): int
    {
        return $this->totalDistance;
    }

    public function getCompensation(): int
    {
        return $this->compensation;
    }

    public function getDueDate(): \DateTimeInterface
    {
        return $this->dueDate;
    }
}
