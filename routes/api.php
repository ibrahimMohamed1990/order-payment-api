<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;

   Route::post('/register', [AuthController::class, 'register']);
   Route::post('/login', [AuthController::class, 'login']);

   Route::middleware('auth:api')->group(function () {

    // User
    Route::get('/user', fn (Request $request) => $request->user());

    // Orders
    Route::post('/orders',        [OrderController::class, 'store']);
    Route::get('/orders',         [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::put('/orders/{order}', [OrderController::class, 'update']);
    Route::delete('/orders/{order}', [OrderController::class, 'destroy']);

    Route::post('/orders/{order}/confirm', [OrderController::class, 'confirm']);
    Route::post('/orders/{order}/cancel',  [OrderController::class, 'cancel']);

    // Payments
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::get('/payments',  [PaymentController::class, 'index']);
    Route::get('/payments/{payment}', [PaymentController::class, 'show']);

    Route::post('/payments/{payment}/confirm', [PaymentController::class, 'confirm']);
    Route::post('/payments/{payment}/fail',    [PaymentController::class, 'fail']);
 });


 Route::get('/change-test-password', function () {
    $user = \App\Models\User::where('email', 'della.swift@example.org')->first();
    $user->password = bcrypt('newpassword123');
    $user->save();
    return 'Password changed!';
});