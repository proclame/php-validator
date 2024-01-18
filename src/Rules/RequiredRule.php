<?php

namespace Proclame\Validator\Rules;

class RequiredRule extends AbstractRule
{
    protected bool $nullable = false;

    protected function rule($value): bool
    {
        if (empty($value)) {
            return false;
        }
        return true;
    }
}