<?php

namespace App\Validator;

class ArrayOfIntegerValidator extends BaseValidator
{
    public function isValid(): bool
    {
        if (!is_array($this->value)) {
            return false;
        }
        
        foreach ($this->value as $arrayValue) {
            if (!is_numeric($arrayValue)) {
                return false;
            }
        }
        return true;
    }
}
