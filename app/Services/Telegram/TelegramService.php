<?php

namespace App\Services\Telegram;

use App\Contracts\Telegram\TelegramServiceContract;
use App\Models\User;
use Telegram\Bot\Objects\Update;

class TelegramService implements TelegramServiceContract
{
    public function respond(Update $update): void
    {

        try {
            \Log::debug('telegramservice respond', [$update->objectType(), $update]);

            $state = \StateService::getByUpdate($update);

            $botResponse = app($state->handler);

            $botResponse->respond($update, $state);
        }catch (\Exception $e) {
            \Log::debug('telegramservice exception', [$e->getMessage()]);
        }
    }

    public function getUser(Update $update): User
    {
        $telegramUser = $update->getMessage()->from;

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
