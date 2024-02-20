<?php

use App\Http\Controllers\Api\V1\Event\EventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::prefix('events')->group(function () {
        Route::get('/', [EventController::class, 'index']);
        Route::get('{id}', [EventController::class, 'show']);
        Route::post('/', [EventController::class, 'store']);
        Route::put('{id}', [EventController::class, 'update']);
        Route::delete('{id}', [EventController::class, 'destroy']);
    });
});
