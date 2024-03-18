<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::POST('device/register', [DeviceController::class, 'store']);
Route::POST('/subscription/purchase', [SubscriptionController::class, 'purchase']);
Route::POST('/subscription/check', [SubscriptionController::class, 'checkStatus']);
