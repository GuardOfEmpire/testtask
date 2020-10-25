<?php

namespace App;

class SplitArrayNumbers
{
    public function split(int $number, array $intNumbers)
    {
        $numbersCount = count($intNumbers);
        
        $correctNumberCount = 0;
        
        foreach ($intNumbers as $key => $currentNumber) {
            if ($number == $currentNumber) {
                $correctNumberCount++;
            }
        }
        
        if (!$correctNumberCount) {
            return -1;
        }
        
        $splitPosition = -1;
        
        $notCorrectnumber = 0;
        
        for ($key = $numbersCount - 1; $key > 1; $key--) {
            if ($number == $intNumbers[$key]) {
                $correctNumberCount--;
            }
            else {
                $notCorrectnumber++;
            }
            
            if (!$correctNumberCount) {
                $splitPosition = -1;
                break;
            }

            if ($correctNumberCount == $notCorrectnumber) {
                $splitPosition = $key;
                break;
            }
            
        }

        return $splitPosition;
    }
}
