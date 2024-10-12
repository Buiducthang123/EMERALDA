<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;


Route::post('/register',[AuthController::class,'register'])->name('register');
Route::post('/login',[AuthController::class,'login'])->name('login');

//Admin
Route::prefix('users')->middleware(['auth:sanctum',AdminMiddleware::class])->group(function(){
    Route::get('/all',[UserController::class,'getAll'])->name('users.all');
    Route::post('/create',[UserController::class,'create'])->name('users.create');
    Route::patch('/update/{id}',[UserController::class,'update'])->name('users.update');
    Route::delete('/delete/{id}',[UserController::class,'delete'])->name('users.delete');
    Route::delete('/soft-delete/{id}',[UserController::class,'softDelete'])->name('users.soft-delete');
});

Route::get('/user/info',[UserController::class,'getUserInfo'])->name('users.info')->middleware('auth:sanctum');
//User
Route::prefix('user')->group(function(){
    Route::get('/me/{id}',[UserController::class,'me'])->name('user.me');
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
    Route::post('',[RoomTypeController::class,'create'])->name('room-types.create');
    Route::patch('/{id}',[RoomTypeController::class,'update'])->name('room-types.update');
    Route::get('/{id}',[RoomTypeController::class,'getRoomType'])->name('room-types.get');
});

//Amenity
Route::get('amenities',action: [AmenityController::class,'index'])->name('amenities.index');
Route::prefix('amenities')->middleware(['auth:sanctum',AdminMiddleware::class])->group(function(){
    Route::post('',action: [AmenityController::class,'create'])->name('amenities.create');
    Route::patch('/{id}',[AmenityController::class,'update'])->name('amenities.update');
    Route::delete('/{id}',[AmenityController::class,'delete'])->name('amenities.delete');

});

//Booking
Route::get('/bookings/booked-date',[BookingsController::class,'getAllBookedDates'])->name('bookings.booked-date');

//
Route::get('/send-mail', [SendMailController::class, 'sendMail'])->name('send-mail');

//Voucher

Route::get('/vouchers/{slug}',[VoucherController::class,'findVoucher'])->name('vouchers.index');
