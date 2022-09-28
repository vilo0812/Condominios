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

//Ruta de los Tickets
Route::group(['prefix' => 'tickets'], function () {
    Route::get('ticket-create', [TicketsController::class, 'create']);
    Route::post('ticket-store', [TicketsController::class, 'store']);
    // Para el usuario
    Route::get('ticket-edit-user/{id}', [TicketsController::class, 'editUser']);
    Route::patch('ticket-update-user/{id}', [TicketsController::class, 'updateUser']);
    Route::get('ticket-list-user', [TicketsController::class, 'listUser']);
    Route::get('ticket-show-user/{id}', [TicketsController::class, 'showUser']);
    // Para el Admin
    Route::get('ticket-edit-admin/{id}', [TicketsController::class, 'editAdmin']);
    Route::patch('ticket-update-admin/{id}', [TicketsController::class, 'updateAdmin']);
    Route::get('ticket-list-admin', [TicketsController::class, 'listAdmin']);
    Route::get('ticket-show-admin/{id}',  [TicketsController::class, 'showAdmin']);
});
