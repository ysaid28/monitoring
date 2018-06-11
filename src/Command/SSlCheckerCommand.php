<?php

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SSlCheckerCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'app:ssl:checker';

    protected function configure()
    {
        $this
            ->setDescription('SSL Certificate checke')
            ->addOption('run', 'r', InputOption::VALUE_NONE, 'Run a dry-run test (no notification)')
            ->addOption('all', 'a', InputOption::VALUE_NONE, 'option to run all plateforms tests (by default)');;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $run = $input->getOption('run');
        $all = true === $input->getOption('all');
        if ($run) {
            $this->getContainer()->get('app.ssl.service')->certificatesChecker($io);
        }

        $io->success('SSL Certificate checked successfully! ');
    }
}
