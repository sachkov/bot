<?php

namespace App\Providers;

use App\Library\Enum\StateEnum;
use App\Library\Telegram\Responses\DefaultResponse;
use App\Library\Telegram\Responses\Pray\AddPrayDescrResponse;
use App\Library\Telegram\Responses\Pray\AddPrayLengthResponse;
use Illuminate\Support\ServiceProvider;

class TelegramResponseProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(StateEnum::DEFAULT->value, DefaultResponse::class);
        $this->app->bind(StateEnum::ADD_PRAY_DESCR->value, AddPrayDescrResponse::class);
        $this->app->bind(StateEnum::ADD_PRAY_TIME->value, AddPrayLengthResponse::class);
    }

    public function boot()
    {
        //
    }
}
