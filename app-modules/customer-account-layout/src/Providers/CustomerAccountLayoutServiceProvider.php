<?php

namespace Modules\CustomerAccountLayout\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CustomerAccountLayoutServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'customer-account-layout');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/customer-account-routes.php');

        Blade::component('customer-account-layout::layout', 'customer-account-layout::layout');
    }
}
