<?php

use App\Http\Controllers\SendMailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send-mail', [SendMailController::class, 'sendMail']);
