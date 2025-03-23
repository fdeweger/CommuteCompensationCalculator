<?php

namespace App\Entity;

class InputRecord
{
    private readonly TransportType $transportType;

    private readonly int $workingDays;


    public function __construct(
        private readonly string $name,
        string $transportType,
        private readonly int $distance,
        float $workingDays
    ) {
        $this->transportType = TransportType::from($transportType);
        $this->workingDays = ceil($workingDays);
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

    public function getWorkingDays(): int
    {
        return $this->workingDays;
    }
}
