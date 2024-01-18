<?php

namespace Proclame\Validator\Rules;

class ArrayRule extends AbstractRule
{
    protected string $errorMessage = ':key is not a valid array';

    protected function rule($value): bool
    {
        return is_array($value);
    }
}