<?php

namespace Proclame\Validator\Rules;

class MaxLengthRule extends AbstractRule
{
    protected string $errorMessage = ":key has a minimum length";

    public function __construct(private int $maxLength)
    {
    }

    protected function rule($value): bool
    {
        return strlen($value) <= $this->maxLength;
    }
}