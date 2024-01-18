<?php

namespace Proclame\Validator\Rules;

class EmailRule extends AbstractRule
{
    protected string $errorMessage = 'Not a valid e-mail address';

    protected function rule($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    protected function sanitized($value)
    {
        return filter_var($value, FILTER_SANITIZE_EMAIL);
    }
}