<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\DataController;
use App\Http\Controllers\api\v1\auth\GoogleController;

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

Route::group(['prefix' => 'v1'], function () {

    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'authenticate']);
    Route::get('/open', [DataController::class, 'open']);

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('/user', [UserController::class, 'getAuthenticatedUser']);
        Route::get('/closed', [DataController::class, 'closed']);
    });

    // login with google
    Route::group(['middleware' => ['web']], function () {
        Route::get('/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
        Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
    });
});

