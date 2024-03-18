<?php

use App\Http\Controllers\DeviceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::POST('device/register', [DeviceController::class, 'store']);

Route::POST('/subscription/purchase', function () {
    return response()->json(['message' => 'subscription purchased']);
});

Route::POST('/subscription/check', function () {
    return response()->json(['message' => 'subscription checked']);
});
