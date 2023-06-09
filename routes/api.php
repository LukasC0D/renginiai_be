<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');

Route::resource('/event', EventController::class, ['only' => ['index', 'show']]);
Route::resource('/event', EventController::class, ['except' => ['index', 'show']])->middleware('auth:sanctum');

Route::post('/event/{eventId}/participate', [EventController::class, 'participate'])->middleware('auth:sanctum');
Route::post('/event/{eventId}/cancel-participation', [EventController::class, 'participate'])->middleware('auth:sanctum');

Route::get('coming-events', [EventController::class, 'getComingEvents']);
Route::get('passed-events', [EventController::class, 'getPassedEvents']);
Route::get('/event-user/{id}', [EventController::class, 'getEventUser']);


