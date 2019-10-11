<?php

namespace Semilock\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Semilock\ExtractVersions;

class GenerateCommand extends Command
{

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'semilock:generate';

    protected function configure()
    {
        $this->setDescription("Given a composer.json and composer.lock file, this command generates a new .json file for distribution")
          ->addArgument("json", InputArgument::REQUIRED, 'The location of the composer.json file')
          ->addArgument("lock", InputArgument::REQUIRED, 'The location of the composer.lock file');

        $this->addOption(
          'output',
          '-o',
          InputOption::VALUE_OPTIONAL,
          'Define the output path to be generated',
          null
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['Extracting versions and generating new composer.json...']);

        if ($input->hasOption('output')) {
          $output->writeln(ExtractVersions::extractFromFiles(
            $input->getArgument('json'),
            $input->getArgument('lock'),
            $input->getOption('output')
          ));

          $output->writeln($input->getOption('output') . ' created!');
        }
        else {
          $output->writeln(ExtractVersions::extractFromFiles($input->getArgument('json'), $input->getArgument('lock')));
        }
    }
}
