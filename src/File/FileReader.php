<?php

namespace App\File;

use App\Entity\Employee;
use Symfony\Component\Filesystem\Filesystem;

class FileReader
{
    private const HEADERS = [
        'Employee',
        'Transport',
        'Distance',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
    ];

    public function __construct(private readonly Filesystem $fileSystem)
    {
    }

    public function readFile(string $filename): array
    {
        $contents = trim($this->fileSystem->readFile($filename));
        $contents = str_replace("\r\n", "\n", $contents);
        $lines = explode("\n", $contents);

        if (0 === count($lines) || '' === $lines[0]) {
            throw new EmptyInputCsvException('Input file is empty');
        }

        $header = str_getcsv($lines[0]);
        $this->validateHeader($header);

        return $this->readLines($lines);
    }

    private function validateHeader($header): void
    {
        if (8 !== count($header)) {
            throw new InvalidHeaderException('Header doesn\'t contain 8 columns ');
        }

        if (self::HEADERS !== $header) {
            throw new InvalidHeaderException('Input file should have the the following columns: '.implode(', ', self::HEADERS));
        }
    }

    private function readLines(array $lines): array
    {
        $ret = [];

        // Skip the first header line
        for ($i = 1; $i < count($lines); ++$i) {
            $line = str_getcsv($lines[$i]);
            if (8 !== count($line)) {
                throw new InvalidInputRowException(sprintf('Line %s doesn\'t contain 8 columns', $i));
            }

            $workingDays = [];

            for ($j = 1; $j <= 5; ++$j) {
                if (1 === (int) $line[$j + 2]) {
                    $workingDays[] = $j;
                }
            }

            $ret[] = new Employee($line[0], $line[1], $line[2], $workingDays);
        }

        return $ret;
    }
}
