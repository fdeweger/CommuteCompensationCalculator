<?php

namespace App\Record;

class InputRecord
{
    private const ALLOWED_TRANSPORT_TYPES = [
        'Bike',
        'Bus',
        'Car',
        'Train'
    ];

    public function __construct(
        private readonly string $name,
        private readonly string $transportType,
        private readonly int $distance,
        private readonly int $workingDays
    ) {
        if (!in_array($this->transportType, self::ALLOWED_TRANSPORT_TYPES)) {
            throw new InvalidTransportTypeException(
                sprintf(
                    'Invalid transport type %s for %s, must be one of: %s',
                    $this->transportType,
                    $this->name,
                    implode(', ', self::ALLOWED_TRANSPORT_TYPES)
                )
            );
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTransportType(): string
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
