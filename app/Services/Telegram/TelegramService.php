<?php

namespace App\Services\Telegram;

use App\Contracts\Telegram\TelegramServiceContract;
use Telegram\Bot\Objects\Update;

class TelegramService implements TelegramServiceContract
{
    public function respond(Update $update): void
    {
        try {
            \Log::debug('telegramservice respond', [$update->objectType(), $update]);

            $state = \StateService::getByUpdate($update);

            if (is_null($state)) {
                return;
            }

            $botResponse = app($state->handler);

            $botResponse->respond($update, $state);
        }catch (\Exception $e) {
            \Log::debug('telegramservice exception', [$e->getMessage() . $e->getFile() . ':' . $e->getLine()]);
        }
    }
}
