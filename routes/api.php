<?php

use App\Http\Controllers\CardsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/create', [UsersController::class, 'create']);
Route::post('/login', [UsersController::class, 'login']);
Route::post('/changePassword', [UsersController::class, 'changePassword']);
Route::post('/user-update', [UsersController::class, 'updateInfo']);

Route::post('/create-card', [CardsController::class, 'create']);
Route::get('/get-cards', [CardsController::class, 'getCards']);
Route::put('/update-card/{id}', [CardsController::class, 'updateCard']);
Route::delete('/delete-card/{id}', [CardsController::class, 'deleteCard']);
Route::get('/mostValuableCards', [CardsController::class, 'mostValuable']);
