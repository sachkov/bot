<?php

namespace App\Contracts\User;

use App\Models\User;
use Telegram\Bot\Objects\Update;

interface UserServiceContract
{
    public function getByTelegramId(int $telegram_id): ?User;
    public function getByUpdate(Update $update): User;
}
