<?php

use Proclame\Validator\Exceptions\ValidationException;
use Proclame\Validator\Rules\AcceptedRule;
use Proclame\Validator\Rules\ArrayRule;
use Proclame\Validator\Rules\CheckboxRule;
use Proclame\Validator\Rules\EmailRule;
use Proclame\Validator\Rules\FloatRule;
use Proclame\Validator\Rules\IntegerRule;
use Proclame\Validator\Rules\MinLengthRule;
use Proclame\Validator\Rules\NumericRule;
use Proclame\Validator\Rules\RequiredRule;
use Proclame\Validator\Validator;

require 'vendor/autoload.php';


$validator = new Validator();

$inputvalues = [
    "array" => ["key" => "value", "key2" => "value2"],
    'name' => 'Nick Mispoulier',
//    'email' => ' nick@proclame.be',
//    'extra value' => "an extra value",
    'accepted checkbox' => 'on',
    "integer" => '123',
//    'checkbox' => 'on',
    "float" => "123.5",
    "number" => "1235",
];

$validator->setRules([
    'array' => [new ArrayRule()],
    'array.key' => [new RequiredRule()],
    "accepted checkbox" => new AcceptedRule(),
    'checkbox' => new CheckboxRule(),
    'name' => [new RequiredRule(), new MinLengthRule(10)],
    'email' => [new EmailRule()],
    'extra value' => [],
    'integer' => [new RequiredRule(), new IntegerRule()],
    "float" => [new FloatRule()],
    "number" => [new NumericRule()],
])->setData($inputvalues);

try {
    $values = $validator->validated();
} catch (ValidationException $e) {
    $errors = $validator->errors();
    var_dump($errors);
    exit;
}

var_dump($values);