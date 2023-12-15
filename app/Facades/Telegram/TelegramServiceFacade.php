<?php

namespace App\Facades\Telegram;

use App\Contracts\Telegram\TelegramServiceContract;
use Illuminate\Support\Facades\Facade;

class TelegramServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TelegramServiceContract::class;
    }
}
