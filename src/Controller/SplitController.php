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
        
        $userId = $this->auth('1', '2');
        
        if (!$userId) {
            throw new \Exception('Неверный логин или пароль');
        }
        
        if (!$requestObject) {
            throw new \Exception('Невалидный запрос');
        }
        
        $validator = $this->makeValidator($requestObject);
        
        if (!$validator->isValid()) {
            $result = -1;
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
        $validatorContainer->addChildValidators(
            new \App\Validator\IsIntegerValidator($data->number ?? null),
            new \App\Validator\ArrayOfIntegerValidator($data->values ?? null),
        );
        
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

        $executionStore = new \App\Entity\ExecutionHistory();
        $executionStore->setUserId($userId);
        $executionStore->setRequestData(json_encode($requestData));
        $executionStore->setResponse($response);

        $entityManager->persist($executionStore);

        $entityManager->flush();
    }
}