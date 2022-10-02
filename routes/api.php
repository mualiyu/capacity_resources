<?php

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

Route::controller(App\Http\Controllers\UserController::class)->group(function () {
    Route::post('/user/login', 'login');
    Route::post('/user/register', 'register');
}); 

Route::controller(App\Http\Controllers\ResourceController::class)->group(function () {
    Route::get('/resource/get_all', 'get_all');
    Route::post('/resource/create', 'create');
    Route::get('/resource/get_by_id', 'get_by_id');
    // Route::post('/resource/create', 'create');
    Route::get('/search', 'show');
});
 