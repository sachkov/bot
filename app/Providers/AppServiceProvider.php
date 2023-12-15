<?php

namespace App\Providers;

use App\Contracts\Pray\PrayServiceContract;
use App\Contracts\Telegram\TelegramServiceContract;
use App\Services\Pray\PrayService;
use App\Services\Telegram\TelegramService;
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
        $this->app->bind(PrayService::class, PrayServiceContract::class);
    }
}
