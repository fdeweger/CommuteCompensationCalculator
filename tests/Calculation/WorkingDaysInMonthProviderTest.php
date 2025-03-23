<?php

namespace Test\App\Calculation;

use App\Calculation\WorkingDaysInMonthProvider;
use PHPUnit\Framework\TestCase;

class WorkingDaysInMonthProviderTest extends TestCase
{
    public function testWorkingDaysInMonthProvider()
    {
        $provider = new WorkingDaysInMonthProvider();
        $result = $provider->getWorkingDays(2025, 3);

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
}