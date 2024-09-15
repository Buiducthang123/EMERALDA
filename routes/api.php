<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
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
    Route::get('info',[UserController::class,'getUserInfo'])->name('users.info');
});

//User
Route::prefix('user')->group(function(){
    Route::get('/me',[UserController::class,'me'])->name('user.me');
    Route::put('/update-me/{id}',[UserController::class,'updateMe'])->name('user.update-me');
});

//Room
Route::get('/rooms',[RoomController::class,'index'])->name('rooms.index');
Route::prefix('rooms')->middleware(['auth:sanctum',AdminMiddleware::class])->group(function(){
    Route::patch('/{id}',[RoomController::class,'update'])->name('rooms.update');
    Route::post('',[RoomController::class,'store'])->name('rooms.store');
    Route::delete('/{id}',[RoomController::class,'delete'])->name('rooms.delete');
});


//RoomType
Route::prefix('room-types')->group(function(){
    Route::get('',[RoomTypeController::class,'index'])->name('room-types.index');
});

//Amenity
Route::get('amenities',action: [AmenityController::class,'index'])->name('amenities.index');
Route::prefix('amenities')->middleware(['auth:sanctum',AdminMiddleware::class])->group(function(){
    Route::post('',action: [AmenityController::class,'create'])->name('amenities.create');
    Route::patch('/{id}',[AmenityController::class,'update'])->name('amenities.update');
    Route::delete('/{id}',[AmenityController::class,'delete'])->name('amenities.delete');

});


//Feature
Route::get('features', [FeatureController::class, 'index'])->name('features.index');
Route::prefix('/features')->middleware(['auth:sanctum',AdminMiddleware::class])->group(function(){
    Route::patch('/{id}',[FeatureController::class,'update'])->name('features.update');
    Route::delete('/{id}',[FeatureController::class,'delete'])->name('features.delete');
    Route::post('/',[FeatureController::class,'create'])->name('features.create');
});
