<?php

namespace App\Services\Telegram;

use App\Contracts\Telegram\TelegramServiceContract;
use App\Library\Enum\LastQuestionEnum;
use App\Models\User;
use Telegram\Bot\Objects\Update;

class TelegramService implements TelegramServiceContract
{
    public function getUser(Update $update): User
    {
        $telegramUser = $update->message->user;

        $user = User::where('telegram_id', $telegramUser->id);

        if (!$user) {
            $user = User::create([
                'first_name' => $telegramUser->firstName,
                'second_name' => $telegramUser->lastName,
                'telegram_id' => $telegramUser->id,
                'username' => $telegramUser->username,
            ]);
        }

        return $user;
    }

    public function respond(Update $update): void
    {
        if ($update->getMessage()->hasCommand()) {
            return;
        }

        $user = $this->getUser($update);

        $question = $user->question()?->name;

        if (is_null($question)) {
            $question = LastQuestionEnum::ADD_PRAY->value;
        }

        $response = app($question);

        $response->handle($update);
    }
}
