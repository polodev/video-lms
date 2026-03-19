<?php

namespace Modules\Lms\Providers;

use Illuminate\Support\ServiceProvider;

class LmsServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'lms');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/lms-routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
