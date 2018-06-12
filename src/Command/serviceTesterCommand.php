<?php

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class serviceTesterCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'app:service:tester';

    protected function configure()
    {
        $this
            ->setDescription('Test AWS and Netexplo Service')
            ->addOption('run', 'r', InputOption::VALUE_NONE, 'Run a dry-run test (no notification)')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Run tests with notification')
            ->addOption('all', 'a', InputOption::VALUE_NONE, 'option to run all plateforms tests (by default)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $run = $input->getOption('run');
        $force = true === $input->getOption('force');
        $all = true === $input->getOption('all');

        if ($run) {
           $this->getContainer()->get('app.service.tester')->test($io);
        } else {

            $io->listing([
                sprintf('<info>%s --run</info> force a test to be run (with no notification, see --force)', $this->getName()),
                sprintf('<info>%s --force</info> option to run tests with notifications', $this->getName()),
                sprintf('<info>%s --all</info> option to run all plateform tests (by default)', $this->getName()),
            ]);

        }
        $io->success('Services tested successfully! ');
    }
}

/**
 *  dump($run);
            $io->note(sprintf('You passed an argument: %s', $arg1));
            $io->title('Title');
            $io->section('Title');
            $io->listing(['Test#', 'Test2']);
            $io->text(['Test#', 'Test2']);
            $io->comment(['Test#', 'Test2']);
            $io->success('Success');
            $io->error('Error');
            $io->warning('warning');
            $io->caution('caution');
            $io->progressStart(100);
//            for ($i = 0; $i < 100; $i++)
//                $io->progressAdvance($i);
//            $io->progressFinish();
//            $io->progressAdvance(1);
//            $io->table(['Test#', 'Test1'],['Test12', 'Rest23']);
 */
