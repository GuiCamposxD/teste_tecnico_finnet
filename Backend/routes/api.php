<?php

use App\Http\Controllers\PeopleController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookRentalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::delete('/people', [PeopleController::class, 'delete']);
Route::get('/people/{id}', [PeopleController::class, 'getById']);
Route::get('/people', [PeopleController::class, 'list']);
Route::patch('/people', [PeopleController::class, 'update']);
Route::post('/people', [PeopleController::class, 'create']);

Route::delete('/book', [BookController::class, 'delete']);
Route::get('/book/available', [BookController::class, 'listAvailable']);
Route::get('/book/{id}', [BookController::class, 'getById']);
Route::get('/book', [BookController::class, 'list']);
Route::patch('/book', [BookController::class, 'update']);
Route::post('/book', [BookController::class, 'create']);

Route::delete('/book_rental', [BookRentalController::class, 'delete']);
Route::get('/book_rental/{id}', [BookRentalController::class, 'getById']);
Route::get('/book_rental', [BookRentalController::class, 'list']);
Route::post('/book_rental', [BookRentalController::class, 'create']);
