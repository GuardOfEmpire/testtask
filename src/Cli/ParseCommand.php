<?php

namespace App\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ParseCommand extends Command
{
    protected function configure()
    {
        $this->setName('parse')
            ->setDescription('Парсинг данных')
            ->addOption(
                'number',
                null,
                InputOption::VALUE_REQUIRED,
                'Число'
            )
            ->addOption(
                'number_list',
                null,
                InputOption::VALUE_REQUIRED,
                'Список чисел через пробел'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $number     = $input->getOption('number');
        $numberString = $input->getOption('number_list');
        $numberList = explode(' ', $numberString);
        
        $splitter = new \App\SplitArrayNumbers();
        
        $splitPosition = $splitter->split($number, $numberList);
        
        $output->writeln("{$number} / {$numberString}: {$splitPosition}");
        
        return 0;
    }
}