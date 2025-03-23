<?php

namespace App\Command;

use App\Calculation\ComposensationCalculationService;
use App\File\FileReader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:calculate', description: 'Calculate commute costs', )]
class CompensationCalculationCommand extends Command
{
    public function __construct(private readonly FileReader $fileReader, private readonly ComposensationCalculationService $service)
    {
        parent::__construct();
    }

    public function configure(): void
    {
        $this->addArgument('inputfile', InputArgument::OPTIONAL, 'Input CSV file', 'input.csv');
        $this->addOption('outputfile', 'o', InputOption::VALUE_OPTIONAL, 'Output CSV file', 'output.csv');
        $this->addOption('year', 'y', InputOption::VALUE_OPTIONAL, 'Year to calculate', (new \DateTimeImmutable())->format('Y'));
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $records = $this->fileReader->readFile($input->getArgument('inputfile'));
            $results = $this->service->calculate($input->getOption('year'), $records);
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }

        return Command::SUCCESS;
    }
}
