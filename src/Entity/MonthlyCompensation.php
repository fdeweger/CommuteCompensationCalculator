<?php

namespace App\Entity;

class MonthlyCompensation
{
    public function __construct(private readonly int $totalDistance, private readonly int $amount, private readonly \DateTimeInterface $dueDate)
    {
    }

    /**
     * Returns the total distance travelled in KM.
     */
    public function getTotalDistance(): int
    {
        return $this->totalDistance;
    }

    /**
     * Returns the amount due in cents.
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * When is the amount due?
     */
    public function getDueDate(): \DateTimeInterface
    {
        return $this->dueDate;
    }
}
