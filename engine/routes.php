<?php

use Core\Router\Route;


Route::post('/api/sign-up', function(){
    return controller('doSignUp');
});
Route::post('/api/login', function(){
    return controller('doLogin');
});
Route::get('/api/test/{token}', function($token){
    return controller('makeNewQuestion', [$token]);
});




Route::post('/api/test', function(){
    $file = receive('file1', true);

    return 0;
});
Route::get('/test', function(){
    view('test');
});




// test
Route::get('/t1', function(){
    phpView('doSignUp-test');
});
Route::get('/t2', function(){
    phpView('doLogin-test');
});