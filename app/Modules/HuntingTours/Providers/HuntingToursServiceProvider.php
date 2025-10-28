<?php

namespace App\Modules\HuntingTours\Providers;

use App\Modules\HuntingTours\Services\BookingService;
use App\Modules\HuntingTours\Services\GuideService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class HuntingToursServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        Route::group([], function () {
            $this->loadRoutesFrom(__DIR__ . '/../Http/Routes/api.php');
        });
    }

    public function register(): void
    {
        $this->app->singleton(BookingService::class, function ($app) {
            return new BookingService();
        });

        $this->app->singleton(GuideService::class, function ($app) {
            return new GuideService();
        });
    }
}
