<?php

use Core\Router\Route;

// add api path
Route::post('/api/sign-up', fn() => controller('doSignUp'));
Route::post('/api/login', fn() => controller('doLogin'));
Route::post('/api/new_question/{token}', fn($token) => controller('makeNewQuestion', [$token]));

// load index file
Route::get('/*', fn() => view('index'));
