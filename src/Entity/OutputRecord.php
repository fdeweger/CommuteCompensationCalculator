<?php

namespace App\Entity;

use App\Compensation\Compensation;

class OutputRecord
{
    public function __construct(private readonly string $name, private readonly TransportType $transportType, private readonly Compensation $compensation)
    {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getTransportType(): TransportType
    {
        return $this->transportType;
    }

    public function getCompensation(): Compensation
    {
        return $this->compensation;
    }
}