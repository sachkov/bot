<?php

namespace App\Providers;

use App\Contracts\Pray\PrayServiceContract;
use App\Contracts\StateServiceContract;
use App\Contracts\Telegram\TelegramServiceContract;
use App\Contracts\User\UserServiceContract;
use App\Services\Pray\PrayService;
use App\Services\StateService;
use App\Services\Telegram\TelegramService;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(TelegramServiceContract::class, TelegramService::class);
        $this->app->bind(PrayServiceContract::class, PrayService::class);
        $this->app->bind(StateServiceContract::class, StateService::class);
        $this->app->bind(UserServiceContract::class, UserService::class);
    }
}
