<?php

namespace ComposerFixed\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ComposerFixed\ExtractVersions;

class GenerateCommand extends Command
{

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'composer_fixed:generate';

    protected function configure()
    {
        $this->setDescription("Given a composer.json and composer.lock file, this command generates a new .json file for distribution")
          ->addArgument("json", InputArgument::REQUIRED,
            'The location of the composer.json file')
          ->addArgument("lock", InputArgument::REQUIRED,
            'The location of the composer.lock file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(ExtractVersions::extractFromFiles($input->getArgument('json'), $input->getArgument('lock')));
    }
}
