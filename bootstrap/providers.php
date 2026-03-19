<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    App\Providers\VoltServiceProvider::class,
    Modules\CustomerFrontendLayout\Providers\CustomerFrontendLayoutServiceProvider::class,
    Modules\CustomerAccountLayout\Providers\CustomerAccountLayoutServiceProvider::class,
    Modules\Lms\Providers\LmsServiceProvider::class,
    Modules\Auth\Providers\AuthServiceProvider::class,
];
