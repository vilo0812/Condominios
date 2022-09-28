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
    Route::get('ticket-create', [TicketsController::class, 'create'])->name('ticket.create');
    Route::post('ticket-store', [TicketsController::class, 'store'])->name('ticket.store');
    // Para el usuario
    Route::get('ticket-edit-user/{id}', [TicketsController::class, 'editUser'])->name('ticket.edit-user');
    Route::patch('ticket-update-user/{id}', [TicketsController::class, 'updateUser'])->name('ticket.update-user');
    Route::get('ticket-list-user', [TicketsController::class, 'listUser'])->name('ticket.list-user');
    Route::get('ticket-show-user/{id}', [TicketsController::class, 'showUser'])->name('ticket.show-user');
    // Para el Admin
    Route::get('ticket-edit-admin/{id}', [TicketsController::class, 'editAdmin'])->name('ticket.edit-admin');
    Route::patch('ticket-update-admin/{id}', [TicketsController::class, 'updateAdmin'])->name('ticket.update-admin');
    Route::get('ticket-list-admin', [TicketsController::class, 'listAdmin'])->name('ticket.list-admin');
    Route::get('ticket-show-admin/{id}',  [TicketsController::class, 'showAdmin'])->name('ticket.show-admin');
});
