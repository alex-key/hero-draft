<?php

namespace App\Packages\Stability\Providers;

use App\Packages\Stability\HttpClient;
use Illuminate\Support\ServiceProvider;

class StabilityServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(HttpClient::class, function () {
            return new HttpClient();
        });
    }

    public function boot(): void
    {
    }
}
