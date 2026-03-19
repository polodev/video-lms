<?php

namespace Modules\CustomerFrontendLayout\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CustomerFrontendLayoutServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'customer-frontend-layout');

        Blade::component('customer-frontend-layout::layout', 'customer-frontend-layout::layout');
    }
}
