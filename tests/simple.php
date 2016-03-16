<?php
require_once "../vendor/autoload.php";

use Vanqard\Valideer\Validator;

$testArray = [
  'username' => 'thunder@vanqard.com',
  'password' => 'password'
];


$testArray = [
  'username' => 'bill@home.com',
  'password' => 'abc',
  'age' => 100,
  'dob' => new \DateTime('1971-07-22')

];


$validator = (new Validator($testArray))
          ->addRule('required', ['username', 'password'])
          ->addRule('email', 'username')
          ->addRule('length', 'password', ["min" => 6], "Not long enough")
          ->addRule('regex', 'password', ["regex" => "/[0-9]+/"])
          ->addRule('number', 'age', ["min"=> 18, "max" => 34])
          ->addRule('date', 'dob', ["before" => new \DateTime('1972-01-01'), "after" => '1970-01-01'], "You're like, totally the wrong age dood");


var_dump($validator->isValid());

print_r($validator->getErrors());
