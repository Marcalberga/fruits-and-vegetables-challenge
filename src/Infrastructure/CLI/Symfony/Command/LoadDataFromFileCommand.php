<?php

namespace App\Infrastructure\CLI\Symfony\Command;

use App\Application\Command\CLI\LoadDataFromFile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadDataFromFileCommand extends Command
{
    public function __construct(protected LoadDataFromFile $loadDataFromFile)
    {
        parent::__construct();
    }

    protected function configure() {
        $this->setName('app:load-data')
            ->addArgument('path', InputArgument::REQUIRED, 'Path to load data from file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('path');

        if (!file_exists($filePath)) {
            $output->writeln('<error>File not found: ' . $filePath . '</error>');
            return Command::FAILURE;
        }

        $this->loadDataFromFile->execute($filePath);

        $output->writeln('<info>Products imported successfully from ' . $filePath . '</info>');
        return Command::SUCCESS;
    }

}