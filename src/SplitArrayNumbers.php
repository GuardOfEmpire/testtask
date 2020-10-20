<?php

namespace App;

class SplitArrayNumbers
{
    public function split(int $number, array $intNumbers)
    {
        $numberCount = [];
        
        $currentCount = 0;
        
        foreach ($intNumbers as $key => $currentNumber) {
            if ($number == $currentNumber) {
                $currentCount++;
            }
            
            $numberCount[$key] = $currentCount;
        }
        
        $splitPosition = -1;
        
        $nonNumberCount = 0;
        
        for ($key = count($intNumbers); $key-- > 1; ) {
            if ($number != $intNumbers[$key]) {
                $nonNumberCount++;
            }
            
            if ($nonNumberCount == $numberCount[$key - 1]) {
                $splitPosition = $key;
                break;
            }
        }

        return $splitPosition;
    }
}
