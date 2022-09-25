<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

	// rutas de autenticazion
Route::group(['prefix' => 'auth'], function ($router) {

	Route::post('login', 'Api\Auth\AuthController@login');
	Route::post('logout', 'Api\Auth\AuthController@logout');
    Route::post('refresh', 'Api\Auth\AuthController@refresh');
	Route::post('me', 'Api\Auth\AuthController@me');

});

Route::apiresource('users', 'Api\User\UserController');
