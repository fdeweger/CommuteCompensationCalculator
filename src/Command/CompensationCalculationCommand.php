<?php

namespace App\Command;

use App\Calculation\ComposensationCalculationService;
use App\File\FileReader;
use App\File\FileWriter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:calculate', description: 'Calculate commute costs', )]
class CompensationCalculationCommand extends Command
{
    public function __construct(private readonly FileReader $fileReader, private readonly FileWriter $fileWriter, private readonly ComposensationCalculationService $service)
    {
        parent::__construct();
    }

    public function configure(): void
    {
        $this->addOption('inputfile', 'i', InputOption::VALUE_OPTIONAL, 'Input CSV file', 'input.csv');
        $this->addOption('outputfile', 'o', InputOption::VALUE_OPTIONAL, 'Output CSV file', 'output.csv');
        $this->addOption('year', 'y', InputOption::VALUE_OPTIONAL, 'Year to calculate', (new \DateTimeImmutable())->format('Y'));
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $employees = $this->fileReader->readFile($input->getOption('inputfile'));
            $results = $this->service->calculate($input->getOption('year'), $employees);
            $this->fileWriter->writeFile($input->getOption('outputfile'), $results);
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
