<?php

namespace Test\App\Calculation;

use App\Calculation\Calculator\BikeCalculator;
use PHPUnit\Framework\TestCase;

class BikeCalculationTest extends TestCase
{
    private BikeCalculator $bikeCalculator;

    public function setUp(): void
    {
        $this->bikeCalculator = new BikeCalculator();
    }

    /**
     * @dataProvider bikeCalculationProvider
     */
    public function testBikeCalculation(int $expected, int $distance, $daysWorked): void
    {
        $result = $this->bikeCalculator->calculate($distance, $daysWorked);
        $this->assertEquals($expected, $result);
    }

    public function bikeCalculationProvider(): array
    {
        return [
            [0, -1, 10],
            [0, 0, 10],
            [2000, 2, 10],
            [10000, 5, 10],
            [40000, 10, 20],
            [0, 11, 20],
        ];
    }
}
