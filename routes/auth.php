<?php

use App\Http\Controllers\auth\AdminController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\AuthorController;
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

//Route::group([
//    'middleware' => 'api',
//    'prefix' => 'auth'
//], function ($router) {
//    Route::post('/login', [AuthController::class, 'login']);
//    Route::post('/register', [AuthController::class, 'register']);
//    Route::post('/logout', [AuthController::class, 'logout']);
//    Route::post('/refresh', [AuthController::class, 'refresh']);
//    Route::get('/user-profile', [AuthController::class, 'userProfile']);
//});



Route::middleware('api')->group(function (){

    Route::controller(AuthController::class)->prefix('auth')->group(function ($router){
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout',  'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile',  'userProfile');
        Route::get('/verify/{token}' , [AuthController::class , 'verify']);
    });


    Route::controller(AdminController::class)->prefix('admin/auth')->group(function ($router){
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout',  'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile',  'userProfile');
    });


    Route::controller(AuthorController::class)->prefix('author/auth')->group(function ($router){
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout',  'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile',  'userProfile');
    });
});
