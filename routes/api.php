<?php

//Rotas de Login
$this->post('login', 'Auth\AuthenticateController@authenticate');
$this->post('logout', 'Auth\AuthenticateController@logout');
$this->post('login-refresh', 'Auth\AuthenticateController@refreshToken');
$this->get('me', 'Auth\AuthenticateController@getAuthenticatedUser');

Route::get('post', 'Api\PostApiController@index');
Route::get('image', 'Api\ImageApiController@index');

$this->group(['namespace' => 'Api'/* , 'middleware' => 'auth:api' */], function() {
//Rotas de Posts
Route::get('posts/{id}/image', 'Api\PostApiController@image');
Route::apiResource('posts', 'Api\PostApiController');

//Rotas de Images
Route::get('images/{id}', 'Api\ImageApiController@image');
Route::apiResource('images', 'Api\ImageApiController');
});
