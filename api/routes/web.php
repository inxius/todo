<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

// API route group
$router->group(['prefix' => 'user'], function () use ($router) {
    // Matches "/api/register
    $router->post('register', 'AuthController@register');

    // Matches "/api/login
    $router->post('login', 'AuthController@login');
 });

$router->group(['prefix' => 'todo'], function () use ($router){
    // Matches "/todo/add
    $router->post('add', 'TodoController@create');

    // Matches "/todo/done
    $router->post('done', 'TodoController@doneTask');

    // Matches "/todo/delete
    $router->post('delete', 'TodoController@deleteTask');

    // Matches "/todo/active
    $router->get('active', 'TodoController@showTodo');

    // Matches "/todo/finished
    $router->get('finished', 'TodoController@showDone');

    // Matches "/todo/deleted
    $router->get('deleted', 'TodoController@showDeleted');
});
 
