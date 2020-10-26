<?php

namespace App\Controller;

/**
 * Description of SplitController
 */
class SplitController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function index(\Symfony\Component\HttpFoundation\Request $request)
    {
        $response = new \Symfony\Component\HttpFoundation\Response;
        
        $requestObject = json_decode($request->getContent());
        
        $userId = $this->auth($request->getUser(), $request->getPassword());
        
        if (!$userId) {
            throw new \Exception('Неверный логин или пароль');
        }
        
        if (!$requestObject) {
            throw new \Exception('Невалидный запрос');
        }
        
        $validator = $this->makeValidator($requestObject);
        
        if (!$validator->isValid()) {
            throw new \Exception('Невалидный запрос');
        }
        else {
            $splitter = new \App\SplitArrayNumbers();
            $result = $splitter->split($requestObject->number, $requestObject->values);
            $this->storeResult(1, $requestObject, $result);
        }
        
        $response->setContent($result);
        $response->headers->set("Content-Type", 'text/plain');
        
        return $response;
    }
    
    private function makeValidator(\stdClass $data)
    {
        $validatorContainer = new \App\Validator\ValidatorContainer;
        $validatorContainer->addChildValidator(new \App\Validator\IsNumericValidator($data->number ?? null));
        $validatorContainer->addChildValidator(new \App\Validator\ArrayOfNumericValidator($data->values ?? null));
        
        return $validatorContainer;
    }
    
    private function auth($login, $password)
    {
        /** @var \App\Repository\UserRepository $userRepository */
        $userRepository = $this
            ->getDoctrine()
            ->getRepository(\App\Entity\User::class);
        
        return $userRepository->auth($login, $password);
    }
    
    private function storeResult(int $userId, \stdClass $requestData, int $response)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $executionService = new \App\ExecutionHistoryService($entityManager);
        
        $executionService->save($userId, $requestData, $response);
    }
}