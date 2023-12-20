<?php

namespace App\Services\Telegram;

use App\Contracts\Telegram\TelegramServiceContract;
use App\Models\User;
use Telegram\Bot\Objects\Update;

class TelegramService implements TelegramServiceContract
{
    public function respond(Update $update): void
    {
        $type = $update->objectType();
        \Log::debug('telegramservice respond', [$type, $update]);
        if ($update->getMessage()->hasCommand() || $type == 'callback_query') {
            return;
        }

        $user = $this->getUser($update);

        $state = \StateService::getById($update->message->from->id);

        $botResponse = app($state);

        $botResponse->handle($update, $user);
    }

    public function getUser(Update $update): User
    {
        // Переделать в зависимости от типа сoобщения
        $telegramUser = $update->message->from;

        $user = User::where('telegram_id', $telegramUser->id)->first();

        if (!$user) {
            $user = User::create([
                'first_name'    => $telegramUser->firstName,
                'second_name'   => $telegramUser->lastName,
                'telegram_id'   => $telegramUser->id,
                'username'      => $telegramUser->username,
            ]);
        }

        return $user;
    }
}
