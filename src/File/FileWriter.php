<?php

namespace App\File;

use App\Entity\TotalCompensation;

/**
 * There is no usage of symfony file system here...
 * This is because:
 * 1) Unit testing this class has little added value since it contains barely any logic
 * 2) fputcsv handles CSV escaping very well, and there is no str_putcsv like function. I'm not expecting
 *    comma's in employee names, but on the other hand: I've seen stranger things.
 */
class FileWriter
{
    /**
     * @param TotalCompensation[] $compensations
     */
    public function writeFile(string $fileName, array $compensations): void
    {
        $fh = fopen($fileName, 'w');

        foreach ($compensations as $compensation) {
            $row = [];
            $row[] = $compensation->getName();
            $row[] = $compensation->getTransportType()->value;
            foreach ($compensation->getMonthlyCompensations() as $monthlyCompensation) {
                $row[] = $monthlyCompensation->getTotalDistance();
                $row[] = round($monthlyCompensation->getAmount() / 100, 2);
                $row[] = $monthlyCompensation->getDueDate()?->format('Y-m-d');
            }
            fputcsv($fh, $row);
        }

        fclose($fh);
    }
}
