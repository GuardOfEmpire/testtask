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
        
        $validator = $this->makeValidator($requestObject);
        
        if (!$validator->isValid()) {
            $result = -1;
        }
        else {
            $splitter = new \App\SplitArrayNumbers();
            $result = $splitter->split($requestObject->number, $requestObject->values);
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
}


/**
case error:

"number": 3,
"values": [5, 5, 1, 7, 2, 3]

5
 */