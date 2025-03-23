<?php

namespace Tests\App\File;

use App\File\FileReader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class FileReaderTest extends TestCase
{
    private FileReader $reader;
    private $fileSystemMock;

    protected function setUp(): void
    {
        $this->fileSystemMock = $this->createMock(Filesystem::class);
        $this->reader = new FileReader($this->fileSystemMock);
    }

    public function testExceptionWhenReadingEmptyFile()
    {
        $this->fileSystemMock->method('readFile')->willReturn('');
        $this->reader->readFile('foo.csv');
    }
}
