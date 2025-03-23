<?php

namespace Tests\App\Entity;

use App\Entity\Employee;
use App\Entity\TransportType;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{
    public function testExceptionWhenUsingInvalidTransportType(): void
    {
        $this->expectException(\ValueError::class);
        new Employee('Frank', 'Something', 1, 2);
    }

    public function testGetters(): void
    {
        $employee = new Employee('Frank', 'Bike', 1, 2);

        $this->assertEquals('Frank', $employee->getName());
        $this->assertEquals(TransportType::Bike, $employee->getTransportType());
        $this->assertEquals(1, $employee->getDistance());
        $this->assertEquals(2, $employee->getWorkingDays());
    }
}
