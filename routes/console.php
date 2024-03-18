<?php

use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    (new App\Http\Controllers\WorkerController)->checkSubscriptions();
})->hourly();
