<?php

namespace Test\App\Calculation;

use App\Calculation\ComposensationCalculationService;
use App\Calculation\HelperFunctions;
use App\Entity\Employee;
use App\Entity\TransportType;
use PHPUnit\Framework\TestCase;

class CompensationCalculationServiceTest extends TestCase
{
    private ComposensationCalculationService $service;

    private HelperFunctions $helperFunctionsMock;

    protected function setUp(): void
    {
        $this->helperFunctionsMock = $this->createMock(HelperFunctions::class);
        $this->service = new ComposensationCalculationService($this->helperFunctionsMock);
    }

    public function testGetMonthlyCompensation()
    {
        // No matter what, in this test everbody works 1 day per month.
        $this->helperFunctionsMock->method('getNumberOfDaysWorked')->willReturn(1);
        $this->helperFunctionsMock->method('getDueDate')->willReturn(new \DateTime('2025-01-01'));
        $results = $this->service->calculate(1234, [new Employee('Chris', 'Bike', 7, 123)]);

        $this->assertEquals(1, count($results));
        $this->assertEquals('Chris', $results[0]->getName());
        $this->assertEquals(TransportType::Bike, $results[0]->getTransportType());
        $this->assertEquals(12, count($results[0]->getMonthlyCompensations()));

        // If the first month is correct, I assume the other months are correct too, especially since the result
        // is now heavily dependent on mocked values
        $january = $results[0]->getMonthlyCompensations()[0];
        $this->assertEquals(1400, $january->getAmount());
        $this->assertEquals(14, $january->getTotalDistance());
        $this->assertEquals('2025-01-01', $january->getDueDate()->format('Y-m-d'));
    }
}
