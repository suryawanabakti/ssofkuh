<?php

namespace Surya\Sso;

use Illuminate\Support\ServiceProvider;


class SSOFkUhException extends ServiceProvider
{

    public  function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    public  function register()
    {
    }
}
