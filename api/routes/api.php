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

Route::apiresource('users', 'Api\User\UserController')->middleware('jwt.init');
Route::apiresource('condominio', 'Api\Condominio\CondominioController')->middleware('jwt.init');
Route::apiresource('pago', 'Api\Pago\PagosController')->middleware('jwt.init');
Route::post('pago/status_pago/generateFacura', 'Api\Pago\PagosController@statusPagos')->middleware('jwt.init');
