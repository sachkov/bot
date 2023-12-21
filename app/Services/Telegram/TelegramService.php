<?php

namespace App\Services\Telegram;

use App\Contracts\Telegram\TelegramServiceContract;
use App\Library\Enum\CallbackEnum;
use App\Models\User;
use Telegram\Bot\Objects\Update;

class TelegramService implements TelegramServiceContract
{
    public function respond(Update $update): void
    {

        try {
            $type = $update->objectType();
            \Log::debug('telegramservice respond', [$type, $update]);
            if ($update->getMessage()->hasCommand()) {
                return;
            }

            $handlerLabel = match ($type) {
                'callback_query' => $this->getCallbackHandler($update),
                'message' => \StateService::getById($update?->message?->from?->id ?? 0),
                default => false,
            };

            if (!$handlerLabel) {
                return;
            }

            $botResponse = app($handlerLabel);

            $user = $this->getUser($update);

            $botResponse->respond($update, $user);
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

    private function getCallbackHandler($update): string
    {
        $data = $update->callback_query?->data;

        if (!isset($data)) {
            return CallbackEnum::DEFAULT->value;
        }

        $label = explode(config('params.callback.handler_separator'), $data);

        return $label[0];
    }
}
