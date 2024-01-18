<?php

namespace Proclame\Validator\Rules;

class NumericRule extends AbstractRule
{
    protected string $errorMessage = ':key is not a valid number';

    protected function rule($value): bool
    {
        return is_numeric($value);
    }

    protected function convert($value): float|int
    {
        if(str_contains($value, '.')) {
            return (float) $value;
        }
        return (int) $value;
    }
}