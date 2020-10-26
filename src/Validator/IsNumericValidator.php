<?php

namespace App\Validator;

class IsNumericValidator extends BaseValidator
{
    public function isValid(): bool
    {
        return is_numeric($this->value);
    }
}
