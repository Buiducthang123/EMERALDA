<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\CancellationRequestController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\RoomTypeReviewController;
use App\Http\Controllers\StatisticalController;
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
Route::prefix('user')->middleware(['auth:sanctum'])->group(function(){
    Route::get('/me/{id}',[UserController::class,'me'])->name('user.me');
    Route::patch('/update-me',[UserController::class,'updateMe'])->name('user.update-me');
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
    Route::delete('/{id}',[RoomTypeController::class,'delete'])->name('room-types.delete');
});

//Amenity
Route::get('amenities',action: [AmenityController::class,'index'])->name('amenities.index');
Route::prefix('amenities')->middleware(['auth:sanctum',AdminMiddleware::class])->group(function(){
    Route::post('',action: [AmenityController::class,'create'])->name('amenities.create');
    Route::patch('/{id}',[AmenityController::class,'update'])->name('amenities.update');
    Route::delete('/{id}',[AmenityController::class,'delete'])->name('amenities.delete');

});

//Booking
Route::get('/bookings',[BookingsController::class,'getAll'])->name('bookings.all')->middleware('auth:sanctum');
Route::get('/bookings/booked-date',[BookingsController::class,'getAllBookedDates'])->name('bookings.booked-date');
Route::post('/bookings',action: [BookingsController::class,'createBooking'])->name('bookings.create')->middleware('auth:sanctum');
Route::get('bookings/me',[BookingsController::class,'getBookingByUser'])->name('bookings.me')->middleware('auth:sanctum');
Route::post(('bookings/update-status/{id}'),[BookingsController::class,'updateStatus'])->name('bookings.update-status')->middleware(['auth:sanctum','can:updateStatus,App\Models\Booking']);
//Voucher
Route::get('/vouchers/{slug}',[VoucherController::class,'findVoucher'])->name('vouchers.index');
Route::get('/vouchers',[VoucherController::class,'getAll'])->name('vouchers.all')->middleware(['auth:sanctum',AdminMiddleware::class]);
Route::post('/vouchers',[VoucherController::class,'create'])->name('vouchers.create')->middleware(['auth:sanctum',AdminMiddleware::class]);
Route::delete('/vouchers/{id}',[VoucherController::class,'delete'])->name('vouchers.delete')->middleware(['auth:sanctum',AdminMiddleware::class]);
Route::patch('/vouchers/{id}',[VoucherController::class,'update'])->name('vouchers.update')->middleware(['auth:sanctum',AdminMiddleware::class]);
Route::get('/vouchers-ongoing',[VoucherController::class,'getVoucherOngoing'])->name('vouchers.ongoing');

//Payment VNPAY
Route::get('payment',[PaymentController::class,'getAllPayment'])->name('payment.all')->middleware(['auth:sanctum',AdminMiddleware::class]);
Route::get('/vnpay-return', [PaymentController::class, 'vnpayReturn']);
Route::post('/refund',[PaymentController::class,'refund'])->name('payment.refund')->middleware(['auth:sanctum',AdminMiddleware::class]);

//Order
Route::get('/orders/my-orders', [OrderController::class, 'myOrders'])->name('orders.my-orders')->middleware('auth:sanctum');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store')->middleware('auth:sanctum');


//cancel request ( yêu cầu hủy phòng)

Route::post('/cancel-request',[CancellationRequestController::class,'store'])->name('cancel-request.store')->middleware('auth:sanctum');
Route::get("/cancel-request/me",[CancellationRequestController::class,'myCancelRequest'])->name('cancel-request.me')->middleware('auth:sanctum');
Route::delete("/cancel-request/{id}",[CancellationRequestController::class,'delete'])->name('cancel-request.delete')->middleware('auth:sanctum');
Route::get("/cancel-request",[CancellationRequestController::class,'getAll'])->name('cancel-request.all')->middleware(['auth:sanctum']);
Route::post("/cancel-request/update-status/{id}",[CancellationRequestController::class,'updateStatus'])->name('cancel-request.update-status')->middleware(['auth:sanctum']);

//invoice (hóa đơn)
Route::post('/invoices',[InvoiceController::class,'store'])->name('invoices.store')->middleware('auth:sanctum');
Route::get('/invoices/booking',[InvoiceController::class,'findByBooking'])->name('invoices.findByBooking')->middleware('auth:sanctum');
Route::post('/invoices/update-status',[InvoiceController::class,'updateStatus'])->name('invoices.updateStatus')->middleware('auth:sanctum');
Route::get('/invoices/me',[InvoiceController::class,'me'])->name('invoices.me')->middleware('auth:sanctum');

//Statistical
Route::get('/statistical',[StatisticalController::class,'statistical'])->middleware(['auth:sanctum',AdminMiddleware::class]);


//RoomTypeReview

Route::post('/room-type-reviews',[RoomTypeReviewController::class,'store'])->name('room-type-reviews.store')->middleware('auth:sanctum');
Route::get('/room-type-reviews',[RoomTypeReviewController::class,'getAll'])->name('room-type-reviews.all')->middleware(['auth:sanctum',AdminMiddleware::class]);
Route::delete('/room-type-reviews/{id}',[RoomTypeReviewController::class,'delete'])->name('room-type-reviews.delete')->middleware(['auth:sanctum',AdminMiddleware::class]);
