<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExecutionHistoryRepository")
 */
class ExecutionHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $userId;

    /**
     * @ORM\Column(type="text")
     */
    private $requestData;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $response;

    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    public function setRequestData($requestData): void
    {
        $this->requestData = $requestData;
    }

    public function setResponse($response): void
    {
        $this->response = $response;
    }
}
