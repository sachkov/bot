<?php

namespace App\Contracts\Telegram;

use App\Models\State;
use Telegram\Bot\Objects\Update;

interface TelegramUpdateHandlerContract
{
    public function respond(Update $update, State $state): void;
}
