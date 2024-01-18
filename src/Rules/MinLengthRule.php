<?php

namespace Proclame\Validator\Rules;

class MinLengthRule extends AbstractRule
{
    protected string $errorMessage = ":key has a minimum length";

    public function __construct(private int $minLength)
    {
    }

    protected function rule($value): bool
    {
        return strlen($value) >= $this->minLength;
    }
}