<?php

use \apiUnitTester\apiUnitTester;

$tester = new apiUnitTester();
$tester->setMethod('POST');
$tester->setUrl('http://localhost/api/login');
$tester->setData([
    'user' => 'master',
    'pass' => '123456',
]);

$tester->test();

