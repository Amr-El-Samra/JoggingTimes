<?php

use App\Http\Controllers\ApiAdminController;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiJoggingTimeController;
use App\Http\Controllers\ApiManagerController;
use App\Http\Controllers\ApiUserController;
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

Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [ApiAuthController::class, 'logout']);

    Route::post('/joggingtimes', [ApiUserController::class, 'create']);
    Route::get('/joggingtimes', [ApiUserController::class, 'show']);
    Route::put('/joggingtimes/{id}', [ApiUserController::class, 'update']);
    Route::delete('/joggingtimes/{id}', [ApiUserController::class, 'delete']);






});


