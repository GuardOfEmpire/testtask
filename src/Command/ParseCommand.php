<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class ParseCommand extends Command
{
    private \App\ExecutionHistoryService $executionHistoryService;

    private const ARGUMENT_NUMBER      = 'number';
    private const ARGUMENT_NUMBER_LIST = 'number-list';
    private const ARGUMENT_USER_ID     = 'user-id';

    public function __construct(\App\ExecutionHistoryService $executionHistoryService)
    {
        parent::__construct();
        $this->executionHistoryService = $executionHistoryService;
    }

    protected function configure()
    {
        $this->setName('parse')
            ->setDescription('Парсинг данных')
            ->addOption(
                self::ARGUMENT_NUMBER,
                null,
                InputOption::VALUE_REQUIRED,
                'Число'
            )
            ->addOption(
                self::ARGUMENT_NUMBER_LIST,
                null,
                InputOption::VALUE_REQUIRED,
                'Список чисел через пробел'
            )
            ->addOption(
                self::ARGUMENT_USER_ID,
                null,
                InputOption::VALUE_REQUIRED,
                'ID пользователя, от имени которого выполняем запрос'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $number       = $input->getOption(self::ARGUMENT_NUMBER);
        $numberString = $input->getOption(self::ARGUMENT_NUMBER_LIST);
        $userId       = $input->getOption(self::ARGUMENT_USER_ID);
        
        $numberList = explode(' ', $numberString);

        $this->validate($number, $numberList);
        
        $splitter = new \App\SplitArrayNumbers();
        
        $splitPosition = $splitter->split($number, $numberList);
        
        if ($userId) {
            $stdObject = new \stdClass();
            $stdObject->number = $number;
            $stdObject->values = $numberList;
            
            $this->executionHistoryService->save($userId, $stdObject, $splitPosition);
        }
        
        $output->writeln("{$number} / {$numberString}: {$splitPosition}");
//        $output->writeln($splitPosition);
        return 0;
    }
    
    private function validate($number, $numberList): void
    {
        $validatorContainer = new \App\Validator\ValidatorContainer;
        $validatorContainer->addChildValidator(new \App\Validator\IsIntegerValidator($number ?? null));
        $validatorContainer->addChildValidator(new \App\Validator\ArrayOfIntegerValidator($numberList ?? null));
        
        if (!$validatorContainer->isValid()) {
            throw new InvalidArgumentException('Невалидные входные данные');
        }
    }
}