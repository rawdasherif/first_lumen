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
$router->post('login', 'AuthorController@login');
$router->post('authors', ['uses' => 'AuthorController@store']);

$router->group(['prefix' => 'api','middleware' => 'auth:api'], function () use ($router) {
    $router->get('authors',  ['uses' => 'AuthorController@index']);
  
    $router->get('authors/{id}', ['uses' => 'AuthorController@show']);
  
    $router->delete('authors/{id}', ['uses' => 'AuthorController@delete']);
  
    $router->put('authors/{id}', ['uses' => 'AuthorController@update']);
    
    
  });

  $router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('articals',  ['uses' => 'ArticalController@index']);
  
    $router->get('articals/{id}', ['uses' => 'ArticalController@show']);
  
    $router->post('articals', ['uses' => 'ArticalController@store']);
  
    $router->delete('articals/{id}', ['uses' => 'ArticalController@delete']);
  
    $router->put('articals/{id}', ['uses' => 'ArticalController@update']);
  });


