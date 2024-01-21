<?php

namespace Proclame\Validator\Rules;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class EmailRule extends AbstractRule
{
    protected string $errorMessage = 'Not a valid e-mail address';
    private EmailValidator $validator;

    public function __construct()
    {
        $this->validator = new EmailValidator();
    }

    protected function rule($value): bool
    {
        return $this->validator->isValid($value, new RFCValidation());
    }
}