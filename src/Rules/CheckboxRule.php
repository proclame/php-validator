<?php

namespace Proclame\Validator\Rules;

final class CheckboxRule extends AbstractRule
{
    protected const VALID_OPTIONS = ['yes', 'on', '1', 1, true, 'true'];
    protected bool $returnBoolean = true;
    protected bool $errorOnFalse = false;
    protected bool $nullable = false;

    protected function rule($value): bool
    {
        if (empty($value)) {
            return false;
        }

        return in_array($value, self::VALID_OPTIONS, true);
    }
}