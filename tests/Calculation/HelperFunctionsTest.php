<?php

namespace Test\App\Calculation;

use App\Calculation\HelperFunctions;
use PHPUnit\Framework\TestCase;

class HelperFunctionsTest extends TestCase
{
    private HelperFunctions $helper;

    public function setUp(): void
    {
        $this->helper = new HelperFunctions([]);
    }

    public function testGetWorkingDays()
    {
        $result = $this->helper->getWorkingDays(2025, 3);

        $this->assertEquals(21, count($result));

        $this->assertEquals(new \DateTime('2025-03-03'), $result[0]);
        $this->assertEquals(new \DateTime('2025-03-04'), $result[1]);
        $this->assertEquals(new \DateTime('2025-03-05'), $result[2]);
        $this->assertEquals(new \DateTime('2025-03-06'), $result[3]);
        $this->assertEquals(new \DateTime('2025-03-07'), $result[4]);

        $this->assertEquals(new \DateTime('2025-03-10'), $result[5]);
        $this->assertEquals(new \DateTime('2025-03-11'), $result[6]);
        $this->assertEquals(new \DateTime('2025-03-12'), $result[7]);
        $this->assertEquals(new \DateTime('2025-03-13'), $result[8]);
        $this->assertEquals(new \DateTime('2025-03-14'), $result[9]);

        $this->assertEquals(new \DateTime('2025-03-17'), $result[10]);
        $this->assertEquals(new \DateTime('2025-03-18'), $result[11]);
        $this->assertEquals(new \DateTime('2025-03-19'), $result[12]);
        $this->assertEquals(new \DateTime('2025-03-20'), $result[13]);
        $this->assertEquals(new \DateTime('2025-03-21'), $result[14]);

        $this->assertEquals(new \DateTime('2025-03-24'), $result[15]);
        $this->assertEquals(new \DateTime('2025-03-25'), $result[16]);
        $this->assertEquals(new \DateTime('2025-03-26'), $result[17]);
        $this->assertEquals(new \DateTime('2025-03-27'), $result[18]);
        $this->assertEquals(new \DateTime('2025-03-28'), $result[19]);

        $this->assertEquals(new \DateTime('2025-03-31'), $result[20]);
    }

    /**
     * @dataProvider dueDateProvider
     */
    public function testGetDueDate(string $expected, int $year, int $month)
    {
        $result = $this->helper->getDueDate($year, $month);
        $this->assertEquals($expected, $result->format('Y-m-d'));
    }

    public function dueDateProvider(): array
    {
        return [
            ['2024-03-04', 2024, 2],
            ['2025-03-03', 2025, 2],
            ['2026-01-05', 2025, 12],
        ];
    }

    /**
     * @dataProvider numberOfDaysWorkedProvider
     */
    public function testGetNumberOfDaysWorked(int $expected, array $employeeWorkingDays)
    {
        $month = [];
        for ($day = 1; $day <= 31; ++$day) {
            $month[] = new \DateTimeImmutable('2025-03-'.$day);
        }

        $this->assertEquals($expected, $this->helper->getNumberOfDaysWorked($month, $employeeWorkingDays));
    }

    public function numberOfDaysWorkedProvider(): array
    {
        return [
            [0, []],
            [5, [1]],
            [4, [5]],
            [13, [1, 3, 5]],
            [21, [1, 2, 3, 4, 5]],
        ];
    }

    public function testPublicHolidays()
    {
        $helper = new HelperFunctions(['2025-03-05']);
        $result = $helper->getWorkingDays(2025, 3);
        $this->assertEquals(20, count($result));
    }
}
