<?php

namespace Tests\App\File;

use App\Entity\TransportType;
use App\File\EmptyInputCsvException;
use App\File\FileReader;
use App\File\InvalidHeaderException;
use App\File\InvalidInputRowException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class FileReaderTest extends TestCase
{
    private FileReader $reader;
    private Filesystem $fileSystemMock;

    protected function setUp(): void
    {
        $this->fileSystemMock = $this->createMock(Filesystem::class);
        $this->reader = new FileReader($this->fileSystemMock);
    }

    public function testExceptionWhenReadingEmptyFile(): void
    {
        $this->fileSystemMock->method('readFile')->willReturn('');
        $this->expectException(EmptyInputCsvException::class);
        $this->reader->readFile('foo.csv');
    }

    public function testExceptionWhenHeadersAreInvalid(): void
    {
        $contents = 'a,b,c,d'.PHP_EOL
            .'Frank,Bike,5,1,1,1,1,1';

        $this->fileSystemMock->method('readFile')->willReturn($contents);
        $this->expectException(InvalidHeaderException::class);
        $this->reader->readFile('foo.csv');
    }

    public function testExceptionWhenHeaderCountDoesntMatch(): void
    {
        $contents = 'Employee,Transport,Distance'.PHP_EOL
            .'Frank,Bike,5,1,1,1,1,1';

        $this->fileSystemMock->method('readFile')->willReturn($contents);
        $this->expectException(InvalidHeaderException::class);
        $this->reader->readFile('foo.csv');
    }

    public function testExceptionWhenRowContainsInvalidNumberOfColumns(): void
    {
        $contents = 'Employee,Transport,Distance,Monday,Tuesday,Wednesday,Thursday,Friday'.PHP_EOL
            .'Frank,Bike,5,1,1';

        $this->fileSystemMock->method('readFile')->willReturn($contents);
        $this->expectException(InvalidInputRowException::class);
        $this->reader->readFile('foo.csv');
    }

    public function testExceptionWhenRowContainsInvalidTransportType(): void
    {
        $contents = 'Employee,Transport,Distance,Monday,Tuesday,Wednesday,Thursday,Friday'.PHP_EOL
            .'Frank,Rocket,10,1,0,1,0,1'.PHP_EOL
            .'X,Car,20,1,1,1,1,1';

        $this->fileSystemMock->method('readFile')->willReturn($contents);
        $this->expectException(\ValueError::class);
        $this->reader->readFile('foo.csv');
    }

    public function testCorrectFileWillBeRead(): void
    {
        $contents = 'Employee,Transport,Distance,Monday,Tuesday,Wednesday,Thursday,Friday'.PHP_EOL
            .'Frank,Bike,10,1,0,1,0,1'.PHP_EOL
            .'X,Car,20,1,1,1,1,1';

        $this->fileSystemMock->method('readFile')->willReturn($contents);
        $results = $this->reader->readFile('foo.csv');

        $this->assertEquals(2, count($results));
        $this->assertEquals('Frank', $results[0]->getName());
        $this->assertEquals(TransportType::Bike, $results[0]->getTransportType());
        $this->assertEquals(10, $results[0]->getDistance());
        $this->assertEquals([1, 3, 5], $results[0]->getWorkingDays());
    }
}
