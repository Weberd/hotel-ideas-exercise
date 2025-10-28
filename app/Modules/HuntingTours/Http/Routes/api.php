<?php

use App\Modules\HuntingTours\Http\Controllers\Api\GetGuidesController;
use App\Modules\HuntingTours\Http\Controllers\Api\StoreHuntingBookingController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::get('/guides', GetGuidesController::class);
    Route::post('/bookings', StoreHuntingBookingController::class);
});
