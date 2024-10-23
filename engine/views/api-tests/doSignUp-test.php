<?php

use \apiUnitTester\apiUnitTester;

$tester = new apiUnitTester();
$tester->setMethod('POST');
$tester->setUrl('http://localhost/api/sign-up');
$tester->setData([
    'user' => 'testUsername',
    'pass' => '123456',
    'firstname' => 'testFirstName',
    'lastname' => 'testLastName',
]);

$tester->test();

