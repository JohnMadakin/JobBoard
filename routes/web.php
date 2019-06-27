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

$router->get($api . 'jobs', [
    'uses' => 'JobController@getJobs'
]);

$router->get( $api . 'jobs/{id}', [
    'uses' => 'JobController@getJobById'
]);
$router->get($api . 'employers/{id}/jobs', [
    'uses' => 'JobController@getJobsByEmployerId'
]);

$router->group(
    ['prefix' => $api, 'middleware' => ['client', 'scopes:admin-privileges']],
    function () use ($router) {
        $router->get('users', [
            'uses' => 'UserController@getUsers'
        ]);
    }
);


$router->group(
    [ 'prefix' => $api, 'middleware' => ['client','canUpdateProfile']],
    function () use ($router) {
        $router->put('profiles/{id}', [
            'uses' => 'ProfileController@updateProfile'
        ]);
    }
);

$router->group(
    ['prefix' => $api, 'middleware' => ['client', 'scopes:create-jobs']],
    function () use ($router) {
        $router->post('jobs', [
            'uses' => 'JobController@createJobs'
        ]);

        $router->put('jobs/{id}', [
            'uses' => 'JobController@updateJobs'
        ]);

        $router->delete('jobs/{id}', [
            'uses' => 'JobController@deleteJob'
        ]);

        $router->get('jobs/{id}/applicants', [
            'uses' => 'ApplicantController@getApplicants'
        ]);
    }
);

$router->group(
    ['prefix' => $api, 'middleware' => ['client', 'scopes:apply-jobs']],
    function () use ($router) {
        $router->post('jobs/{id}/apply', [
            'uses' => 'ApplicantController@applyForJob'
        ]);
    }
);
