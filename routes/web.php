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
$api = 'api/v1/';

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post($api . 'signup', [
    'uses' => 'UserController@register'
]);
$router->post($api . 'login', [
    'uses' => 'UserController@authenticate'
]);


// $router->group(
//     ['middleware' => ['auth', 'authorise']],
//     function () use ($router, $api) {
//         $router->get($api . 'users', [
//             'uses' => 'UserController@getUsers'
//         ]);
//         $router->post($api . 'users', [
//             'uses' => 'UserController@createNewUser'
//         ]);
//     }
// );
