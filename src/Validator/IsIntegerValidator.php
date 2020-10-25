<?php

namespace App\Validator;

class IsIntegerValidator extends BaseValidator
{
    public function isValid(): bool
    {
        return is_numeric($this->value);
    }
}
