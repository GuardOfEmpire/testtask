<?php

namespace App\Validator;

class IsIntegerValidator extends BaseValidator
{
    public function isValid(): bool
    {
        return is_int($this->value);
    }
}
