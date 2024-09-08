<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;


Route::post('/register',[AuthController::class,'register'])->name('register');
Route::post('/login',[AuthController::class,'login'])->name('login');

//Admin
Route::prefix('users')->middleware(['auth:sanctum',AdminMiddleware::class])->group(function(){
    Route::get('/all',[UserController::class,'getAll'])->name('users.all');
    Route::post('/create',[UserController::class,'create'])->name('users.create');
    Route::put('/update/{id}',[UserController::class,'update'])->name('users.update');
    Route::delete('/delete/{id}',[UserController::class,'delete'])->name('users.delete');
    Route::delete('/soft-delete/{id}',[UserController::class,'softDelete'])->name('users.soft-delete');
});

//User
Route::prefix('user')->group(function(){
    Route::get('/me',[UserController::class,'me'])->name('user.me');
    Route::put('/update-me/{id}',[UserController::class,'updateMe'])->name('user.update-me');
});
