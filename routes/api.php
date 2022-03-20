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

Route::get('/cards/code-{code}', [CardController::class, 'show'])->where('code', '\d+');
Route::get('/cards', [CardController::class, 'index']);
Route::post('/cards', [CardController::class, 'create']);
Route::put('/cards/{code}', [CardController::class, 'update']);

Route::get('/orders', [CardOrderController::class, 'index']);
