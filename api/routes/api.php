<?php

use Illuminate\Http\Request;

use App\Http\Controllers\TicketsController;
use App\Http\Controllers\OrderController;
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
//Ruta de los Tickets
Route::controller(TicketsController::class)->group(
    function($router) {
        Route::get('ticket-create','create');
        Route::post('ticket-store','store');
        // Para el usuario
        Route::get('ticket-edit-user/{id}','editUser');
        Route::patch('ticket-update-user/{id}','updateUser');
        Route::get('ticket-list-user', 'listUser');
        Route::get('ticket-show-user/{id}','showUser');
        // Para el Admin
        Route::get('ticket-edit-admin/{id}','editAdmin');
        Route::patch('ticket-update-admin/{id}','updateAdmin');
        Route::get('ticket-list-admin','listAdmin');
        Route::get('ticket-show-admin/{id}','showAdmin');
});


//Rutas para ordenes
Route::controller(OrderController::class)->group(
	function($router) {
		Route::get('/ordenes','index');
        Route::post('/cambiarStatus','update');
});

