<?php

namespace App\Modules\HuntingTours\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class HuntingToursServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../Http/Routes/api.php');
        });
    }

    public function register(): void
    {
    }

    protected function routeConfiguration(): array
    {
        return [
            'prefix' => config('hunting.route_prefix', 'api'),
            'middleware' => config('hunting.route_middleware', ['api']),
        ];
    }
}
