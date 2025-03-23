<?php

namespace Tests\App\Calculation;

use App\Calculation\Calculator\FixedKilometerPriceCalculator;
use PHPUnit\Framework\TestCase;

class FixedKilometerPriceCalculatorTest extends TestCase
{
    /**
     * @dataProvider fixedKilometerPriceCalculationProvider
     */
    public function testFixedKilometerPriceCalculation(int $expected, int $PricePerKilometer, int $distance, $daysWorked): void
    {
        $calculator = new FixedKilometerPriceCalculator($PricePerKilometer);
        $result = $calculator->calculate($distance, $daysWorked);
        $this->assertEquals($expected, $result);
    }

    public function fixedKilometerPriceCalculationProvider(): array
    {
        return [
            [0, 10, -1, 10],
            [0, 10, 0, 10],
            [400, 10, 2, 10],
            [3250, 25, 5, 13],
        ];
    }
}
