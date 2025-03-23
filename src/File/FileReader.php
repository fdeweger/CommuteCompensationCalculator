<?php

namespace App\File;

use Symfony\Component\Filesystem\Filesystem;

class FileReader
{
    private const HEADERS = [
        "Employee",
        "Transport",
        "Distance",
        "Workdays per week"
    ];

    public function __construct(private readonly Filesystem $fileSystem)
    {
    }

    public function readFile(string $filename): array
    {
        $contents = trim($this->fileSystem->readFile($filename));
        $contents = str_replace("\r\n", "\n", $contents);
        $lines = explode("\n", $contents);

        if (count($lines) === 0) {
            throw new EmptyInputCsvException('Input file is empty');
        }

        $header = str_getcsv($lines[0]);
        $this->validateHeader($header);

        return $this->readLines($lines);
    }

    private function validateHeader($header): void
    {
        if (count($header) !== 4) {
            throw new InvalidHeadersException('Input file should have 4 header columns');
        }

        if ($header !== self::HEADERS) {
            throw new InvalidHeadersException('Input file should have the the following columns: '
                . implode(', ', self::HEADERS));
        }
    }

    private function readLines(array $lines): array
    {
        $ret = [];
        // Skip the first header line
        for ($i = 1; $i < count($lines); $i++) {
            $ret[] = $this->readLine($lines[$i]);
        }

        return $ret;
    }

    private function readLine(string $line): array
    {
        return str_getcsv($line);
    }
}
