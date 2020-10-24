<?php

namespace App\Validator;

abstract class BaseValidator implements ValidatorInterface
{
    protected $value;

    public function __construct($value)
    {
        $this->value   = $value;
    }
}
