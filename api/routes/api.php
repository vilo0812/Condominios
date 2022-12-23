<?php

use Illuminate\Http\Request;

use App\Http\Controllers\TicketsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Api\Support\SupportController;
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
//Rutas ticket


Route::delete('ticket-delete/{id}',[SupportController::class,'delete']);
Route::post('ticket-store',[SupportController::class,'store']);
//Rutas ticket admin
Route::get('ticket-list-admin',[SupportController::class,'listAdmin']);
Route::post('ticket-update-admin',[SupportController::class,'updateAdmin']);
Route::get('ticket-show-admin/{id}',[SupportController::class,'showAdmin']);
//Rutas ticket user
Route::post('ticket-update-user',[SupportController::class,'updateUser']);
Route::get('ticket-list-user',[SupportController::class, 'listUser']);
Route::get('ticket-show-user/{id}',[SupportController::class,'showUser']);



Route::apiresource('users', 'Api\User\UserController')->middleware('jwt.init');
Route::apiresource('condominio', 'Api\Condominio\CondominioController')->middleware('jwt.init');
Route::apiresource('pago', 'Api\Pago\PagosController')->middleware('jwt.init');
Route::post('pago/status_pago/generateFacura', 'Api\Pago\PagosController@statusPagos')->middleware('jwt.init');


//Rutas para ordenes
Route::controller(OrderController::class)->group(
	function($router) {
		Route::get('/ordenes','index');
        Route::post('/cambiarStatus','update');
});

