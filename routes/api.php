<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\CardOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(CardController::class)->group(function () {
    Route::get('/cards/code-{code}', 'show')->whereNumber('code');
    Route::get('/cards', 'index');
    Route::post('/cards', 'create');
    Route::put('/cards/{code}', 'update')->whereNumber('code');
});

Route::controller(CardOrderController::class)->group(function () {
    Route::get('/orders', 'index');
    Route::post('/orders', 'create');
    Route::put('/orders/{order}', 'update')->whereNumber('order');
});

