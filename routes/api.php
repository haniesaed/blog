<?php

use App\Http\Controllers\AdminDashboard\AdminNotificationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UpdatePost;
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


Route::middleware('auth:admin')->prefix('admin')->group(function (){

    Route::controller(AdminNotificationController::class)->prefix('/notification')->group(function (){
        Route::get('/all' , ' index');
        Route::get('/unread' , ' unread');
        Route::post('/markRead/All' , 'markReadAll')->middleware('isAdmin');
        Route::delete('/delete/All' , 'deleteAll')->middleware('jwt.verify' , 'isAdmin');
        Route::delete('/delete/{id}' , 'delete')->middleware('jwt.verify' , 'isAdmin');
    });
    Route::get('/post/pending' , [App\Http\Controllers\AdminDashboard\PostStatusController::class , 'pendingPosts']);
    Route::put('/post/status' , [App\Http\Controllers\AdminDashboard\PostStatusController::class , 'changeStatus']);
    Route::resource('/post' , PostController::class)->except('store');

    Route::resource("category" , CategoryController::class)->middleware('isAdmin');
    Route::resource("tag" , TagController::class)->middleware('isAdmin');

});

Route::middleware('auth:author')->prefix('author')->group(function (){

    Route::resource('/post' , PostController::class)->middleware( 'checkPlan');
    Route::post('/insert/photo' , [PhotoController::class , 'store']);

    Route::controller(UpdatePost::class)->prefix('/post/{post}')->group(function (){
        Route::put('/update' ,  'updateDetails')->middleware('isAdmin');
        Route::put('/updateCategory' ,  'updateCategory')->middleware('isAdmin');
        Route::put('/updateTag' ,  'updateTag')->middleware('isAdmin');
        Route::put('/updatePhotos' ,  'updatePhotos')->middleware('isAdmin');
    });

});

Route::middleware('auth:user')->prefix('user')->group(function (){

    Route::resource('/post' , PostController::class)->only(['show' , 'index']);

});

Route::get('/unauthorized' , function (){
    return response()->json(['message' => "unauthorized" , 401]);
})->name('login');


require 'auth.php';
