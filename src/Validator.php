<?php

namespace Proclame\Validator;

use Proclame\Validator\Exceptions\NotImplementedException;
use Proclame\Validator\Exceptions\ValidationException;
use Proclame\Validator\Exceptions\ValidationRuleException;

class Validator
{

    private array $rules;

    private array $validatedData = [];
    private array $erroredData = [];
    private bool $validationErrorOccured = false;
    private array $inputvalues;

    public function __construct()
    {
    }

    /**
     * @throws NotImplementedException
     */
    public function fromRequest($request): static
    {
        if(method_exists($request, 'getParsedBody')){
            $this->setData($request->getParsedBody());
            return $this;
        }
        throw new NotImplementedException("Not an implemented request format");
    }

    public function setData(array $inputvalues): static
    {
        $this->inputvalues = $inputvalues;

        return $this;
    }

    public function setRules(array $array): static
    {
        $this->rules = [];
        foreach ($array as $key => $rule) {
            $this->addRule($key, $rule);
        }

        return $this;
    }

    /**
     * @throws ValidationException
     */
    public function validate(?array $inputvalues = null): void
    {
        $this->validatedData = [];
        $this->erroredData = [];

        if (!is_null($inputvalues)) {
            $this->inputvalues = $inputvalues;
        }

        foreach ($this->rules as $inputKey => $ruleList) {
            $this->validateRules($inputKey, $ruleList);
        }

        if ($this->validationErrorOccured) {
            throw new ValidationException("Validation Error Occured");
        }
    }

    /**
     * @throws ValidationException
     */
    public function validated(?array $inputvalues = null): array
    {
        $this->validate($inputvalues);

        return $this->validatedData;
    }

    public function errors(): array
    {
        return $this->erroredData;
    }

    private function addRule($key, $rule): void
    {
        if (is_array($rule)) {
            $this->rules[$key] = $rule;
        } else {
            $this->rules[$key] = [$rule];
        }
    }

    private function setOutputValue(&$output, $inputKey, $inputValue): void
    {
        if(!str_contains($inputKey, '.')) {
            $output = array_replace_recursive($output, [$inputKey => $inputValue]);
            return;
        }

        $dotNotationArray = explode(".", $inputKey);
        rsort($dotNotationArray);
        foreach ($dotNotationArray as $key) {
            $inputValue = [$key => $inputValue];
        }
        $output = array_replace_recursive($output, $inputValue);
    }

    private function getInputvalue(string $inputKey): mixed
    {
        if(str_contains($inputKey, '.')){
            $inputvalue = $this->inputvalues ?? null;

            $dotNotationArray = explode(".", $inputKey);
            foreach($dotNotationArray as $key) {
                $inputvalue = $inputvalue[$key] ?? null;
            }
        }

        if(empty($inputvalue)){
            $inputvalue = $this->inputvalues[$inputKey] ?? null;
        }

        return is_string($inputvalue) ? trim($inputvalue) : $inputvalue;
    }

    private function validateRules(string $inputKey, mixed $ruleList): void
    {
        $inputvalue = $this->getInputvalue($inputKey);

        if (count($ruleList) === 0) {
            $this->setOutputValue($this->validatedData, $inputKey, $inputvalue);
        }

        foreach ($ruleList as $rule) {
            try {
                $inputvalue = $rule->validate($inputvalue);
            } catch (ValidationRuleException $e) {
                $this->validationErrorOccured = true;
                $this->erroredData[$inputKey] = strtr($e->getMessage(), [':key' => $inputKey]);
                continue;
            }
            $this->setOutputValue($this->validatedData, $inputKey, $inputvalue);
        }
    }
}