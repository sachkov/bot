<?php

namespace App\Providers;

use App\Library\Enum\CallbackEnum;
use App\Library\Enum\StateEnum;
use App\Library\Telegram\Callback\DefaultCallbackHandler;
use App\Library\Telegram\Callback\Pray\AddPrayLengthCallbackHandler;
use App\Library\Telegram\Callback\Pray\EditPrayLengthCallbackHandler;
use App\Library\Telegram\Callback\Pray\EditPrayMainCallbackHandler;
use App\Library\Telegram\Callback\Pray\EditPrayStopCallbackHandler;
use App\Library\Telegram\Callback\Pray\EditPrayTextCallbackHandler;
use App\Library\Telegram\Callback\Pray\ListPrayCallbackHandler;
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
        $this->app->bind(CallbackEnum::LIST_PRAY->value, ListPrayCallbackHandler::class);
        $this->app->bind(CallbackEnum::EDIT_PRAY_SHOW->value, EditPrayMainCallbackHandler::class);
        $this->app->bind(CallbackEnum::EDIT_PRAY_TEXT->value, EditPrayTextCallbackHandler::class);
        $this->app->bind(CallbackEnum::EDIT_PRAY_LENGTH->value, EditPrayLengthCallbackHandler::class);
        $this->app->bind(CallbackEnum::EDIT_PRAY_STOP->value, EditPrayStopCallbackHandler::class);
    }

    public function boot()
    {
        //
    }
}
