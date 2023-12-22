<?php

namespace App\Providers;

use App\Library\Enum\CallbackEnum;
use App\Library\Enum\StateEnum;
use App\Library\Telegram\Callback\DefaultCallbackHandler;
use App\Library\Telegram\Callback\Pray\AddPrayLengthCallbackHandler;
use App\Library\Telegram\Messages\DefaultMessageHandler;
use App\Library\Telegram\Messages\Pray\AddPrayLengthMessageHandler;
use Illuminate\Support\ServiceProvider;

class TelegramResponseProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(StateEnum::DEFAULT->value, DefaultMessageHandler::class);
        $this->app->bind(StateEnum::ADD_PRAY_LENGTH->value, AddPrayLengthMessageHandler::class);

        $this->app->bind(CallbackEnum::DEFAULT->value, DefaultCallbackHandler::class);
        $this->app->bind(CallbackEnum::ADD_PRAY_LENGTH->value, AddPrayLengthCallbackHandler::class);
    }

    public function boot()
    {
        //
    }
}
