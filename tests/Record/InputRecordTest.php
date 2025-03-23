<?php

namespace Tests\App\Record;

use App\Enum\TransportType;
use App\Record\InputRecord;
use PHPUnit\Framework\TestCase;

class InputRecordTest extends TestCase
{
    public function testExceptionWhenUsingInvalidTransportType(): void
    {
        $this->expectException(\ValueError::class);
        new InputRecord('Frank', 'Something', 1, 2);
    }

    public function testGetters(): void
    {
        $record = new InputRecord('Frank', 'Bike', 1, 2);

        $this->assertEquals('Frank', $record->getName());
        $this->assertEquals(TransportType::Bike, $record->getTransportType());
        $this->assertEquals(1, $record->getDistance());
        $this->assertEquals(2, $record->getWorkingDays());
    }
}
