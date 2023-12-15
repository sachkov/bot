<?php

namespace App\Contracts\Telegram;

use App\Models\User;
use Telegram\Bot\Objects\Update;

interface TelegramServiceContract
{
    public function getUser(Update $update): User;
}
