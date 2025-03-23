<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:calculate', description: 'Calculate commute costs', )]
class CommuteCompensationCalculateCommand extends Command
{
    public function configure(): void
    {
        $this->addArgument('inputfile', InputArgument::OPTIONAL, 'Input CSV file', 'input.csv');
        $this->addOption('outputfile', 'o', InputOption::VALUE_OPTIONAL, 'Output CSV file', 'output.csv');
        $this->addOption('year', 'y', InputOption::VALUE_OPTIONAL, 'Year to calculate', (new \DateTime())->format('Y'));
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Calculating commute costs...');

        return Command::SUCCESS;
    }
}