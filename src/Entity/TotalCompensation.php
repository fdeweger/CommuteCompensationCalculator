<?php

namespace App\Entity;

class TotalCompensation
{
    /**
     * @param MonthlyCompensation[] $monthlyCompensations
     */
    public function __construct(private readonly string $name, private readonly TransportType $transportType, private readonly array $monthlyCompensations)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTransportType(): TransportType
    {
        return $this->transportType;
    }

    /**
     * @return MonthlyCompensation[]
     */
    public function getMonthlyCompensations(): array
    {
        return $this->monthlyCompensations;
    }
}
