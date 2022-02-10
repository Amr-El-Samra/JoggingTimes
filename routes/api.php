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

    Route::post('/users', [ApiManagerController::class, 'create'])->middleware('manager');
    Route::get('/users', [ApiManagerController::class, 'show'])->middleware('manager');
    Route::put('/users/{id}', [ApiManagerController::class, 'update'])->middleware('manager');
    Route::delete('/users/{id}', [ApiManagerController::class, 'deleteUser'])->middleware('managerAdmin');

    Route::post('/admins/users', [ApiAdminController::class, 'createUser'])->middleware('admin');
    Route::post('/admins/joggingtimes', [ApiAdminController::class, 'createRecord'])->middleware('admin');
    Route::get('/admins', [ApiAdminController::class, 'show'])->middleware('admin');
    Route::put('/admins/user/{id}', [ApiAdminController::class, 'updateUser'])->middleware('admin');
    Route::put('/admins/joggingtime/{id}', [ApiAdminController::class, 'updateRecord'])->middleware('admin');
    Route::delete('/admins/joggingtime/{id}', [ApiAdminController::class, 'deleteRecord'])->middleware('admin');

    








});


