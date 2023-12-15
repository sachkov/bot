<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LastCommandServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(RuleResolverContract::class, RuleResolver::class);
    }

    public function boot()
    {
        //
    }
}
