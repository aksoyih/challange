<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::POST('device/register', [DeviceController::class, 'store']);

Route::group(['middleware' => 'client'], function () {
    Route::POST('/subscription/purchase', [SubscriptionController::class, 'purchase']);
    Route::POST('/subscription/check', [SubscriptionController::class, 'checkStatus']);
});
