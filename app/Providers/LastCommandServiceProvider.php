<?php

namespace App\Providers;

use App\Library\Enum\StateEnum;
use App\Library\Telegram\Responses\DefaultResponse;
use Illuminate\Support\ServiceProvider;

class LastCommandServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(StateEnum::DEFAULT->value, DefaultResponse::class);
    }

    public function boot()
    {
        //
    }
}
