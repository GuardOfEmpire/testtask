<?php

namespace App;

class ExecutionHistoryService
{
    private $entityManager;

    public function __construct(\Doctrine\ORM\EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function save(int $userId, \stdClass $requestData, int $response)
    {
        $executionStore = new \App\Entity\ExecutionHistory();
        $executionStore->setUserId($userId);
        $executionStore->setRequestData(json_encode($requestData));
        $executionStore->setResponse($response);

        $this->entityManager->persist($executionStore);

        $this->entityManager->flush();
    }
}