<?php

namespace Proclame\Validator\Rules;
use Proclame\Validator\Exceptions\ValidationRuleException;

abstract class AbstractRule
{
    protected string $errorMessage = 'Validation error in :key';
    protected bool $returnBoolean = false;
    protected bool $errorOnFalse = true;
    protected bool $nullable = true;

    abstract protected function rule($value): bool;

    /**
     * @throws ValidationRuleException
     */
    final public function validate($value)
    {
        if($this->nullable && ($value === null || $value === '')){
            return null;
        }

        if (method_exists(static::class, 'sanitize')) {
            $value = $this->sanitize($value);
        }

        if (($check = $this->rule($value)) === false && $this->errorOnFalse) {
            throw new ValidationRuleException($this->errorMessage);
        }

        if($this->returnBoolean) {
            return $check;
        }

        if (method_exists(static::class, 'convert')) {
            $value = $this->convert($value);
        }

        return $value;
    }

}