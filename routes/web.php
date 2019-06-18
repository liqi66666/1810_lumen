<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->post('/user/Login','User\UserController@Login');
$router->post('/user/reg','User\UserController@reg');
$router->post('/user/update','User\UserController@update');

$router->post('/login/register','Login\LoginController@register');
$router->post('/login/login','Login\LoginController@login');

$router->post('/curl/encry1','Curl\CurlController@encry1');
$router->post('/curl/encry2','Curl\CurlController@encry2');
$router->post('/curl/rsa1','Curl\CurlController@rsa1');
$router->post('/curl/rsa2','Curl\CurlController@rsa2');
$router->post('/curl/rsa3','Curl\CurlController@rsa3');

$router->get('/curl/curl2','Curl\CurlController@curl2');
$router->post('/curl/curl3','Curl\CurlController@curl3');
$router->post('/curl/curl4','Curl\CurlController@curl4');