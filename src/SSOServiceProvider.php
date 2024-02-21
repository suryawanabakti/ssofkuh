<?php

namespace Surya\Sso;

use Illuminate\Support\ServiceProvider;


class SSOServiceProvider extends ServiceProvider
{

    public static function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
    }

    public  function register()
    {
    }
}
