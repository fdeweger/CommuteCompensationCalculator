<?php

namespace Tests\App\Entity;

use App\Entity\Employee;
use App\Entity\TransportType;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{
    public function testGetters(): void
    {
        $employee = new Employee('Frank', 'Bike', 1, [2, 3, 5]);

        $this->assertEquals('Frank', $employee->getName());
        $this->assertEquals(TransportType::Bike, $employee->getTransportType());
        $this->assertEquals(1, $employee->getDistance());
        $this->assertEquals([2, 3, 5], $employee->getWorkingDays());
    }
}
