<?php

namespace App\Services\User;

use App\Contracts\User\UserServiceContract;
use App\Models\User;
use Telegram\Bot\Objects\Update;

class UserService implements UserServiceContract
{
    public function getByTelegramId(int $telegram_id): ?User
    {
        return User::where('telegram_id', $telegram_id)->first();
    }

    public function getByUpdate(Update $update): User
    {
        $type = $update->objectType();
        $from = match($type) {
            'callback_query' => $update->callbackQuery->from,
            'message' => $update->message->from,
        };

        return User::create([
            'first_name'    => $from->firstName,
            'second_name'   => $from->lastName,
            'telegram_id'   => $from->id,
            'username'      => $from->username,
        ]);
    }
}
