<?php

namespace App\Entity;

class Employee
{
    private readonly TransportType $transportType;

    public function __construct(
        private readonly string $name,
        string $transportType,
        private readonly int $distance,
        private readonly array $workingDays,
    ) {
        $this->transportType = TransportType::from(trim($transportType));
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTransportType(): TransportType
    {
        return $this->transportType;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }

    /**
     * Returns an array that indicates on which day an employee is working, 1 = Monday ... 5 = Friday.
     */
    public function getWorkingDays(): array
    {
        return $this->workingDays;
    }
}
