<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HomeServiceController;
use App\Http\Controllers\Api\BookingTransactionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(HomeServiceController::class)->group(function () {
    Route::get('service/{homeService:slug}', 'show')->name('services.show');
    Route::apiResource('services', HomeServiceController::class)->only([
        'index',
        'store',
        'update',
        'destroy'
    ]);
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/category/{category:slug}', 'show')->name('category.show');
    Route::apiResource('categories', CategoryController::class)->only([
        'index',
        'store',
        'update',
        'destroy'
    ]);
});

Route::controller(BookingTransactionController::class)->group(function () {
    Route::post('/booking-transaction', 'store')->name('booking.store');
    Route::post('/check-booking', 'booking_details')->name('booking.check');
});
