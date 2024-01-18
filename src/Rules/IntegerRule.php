<?php

namespace Proclame\Validator\Rules;

class IntegerRule extends AbstractRule
{
    protected string $errorMessage = ':key is not a valid whole number';

    protected function rule($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    protected function convert($value): int
    {
        return (int) $value;
    }
}