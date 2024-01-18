<?php

namespace Proclame\Validator\Rules;

class FloatRule extends AbstractRule
{
    protected string $errorMessage = ':key is not a valid floating point number';

    protected function rule($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
    }

    protected function convert($value): float
    {
        return (float) $value;
    }
}