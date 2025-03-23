<?php

namespace App\Record;

use App\Enum\TransportType;

class InputRecord
{
    private readonly TransportType $transportType;

    public function __construct(
        private readonly string $name,
        string $transportType,
        private readonly int $distance,
        private readonly int $workingDays,
    ) {
        $this->transportType = TransportType::from($transportType);
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
