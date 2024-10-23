<?php

use Core\Router\Route;

// add api path
Route::post('/api/sign-up', function(){
    return controller('doSignUp');
});
Route::post('/api/login', function(){
    return controller('doLogin');
});
Route::post('/api/new_question/{token}', function($token){
    return controller('makeNewQuestion', [$token]);
});

// load index file
Route::get('/*', function(){
    view('index');
});
