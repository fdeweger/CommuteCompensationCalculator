<?php

namespace App\File;

use App\Record\InputRecord;
use Symfony\Component\Filesystem\Filesystem;

class FileReader
{
    private const HEADERS = [
        'Employee',
        'Transport',
        'Distance',
        'Workdays per week',
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
        if (4 !== count($header)) {
            throw new InvalidHeaderException('Input file should have 4 header columns');
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
            if (count($line) !== 4) {
                throw new InvalidInputRowException(sprintf('Line %s doesnt contain 4 columns', $i));
            }

            $ret[] = new InputRecord(...str_getcsv($lines[$i]));
        }

        return $ret;
    }
}
