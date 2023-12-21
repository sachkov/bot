<?php

namespace App\Library\Telegram\Messages;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

abstract class AbstractMessageHandler
{
    protected User $user;
    protected Api $bot;
    protected string $text;

    public function respond(Update $update, User $user): void
    {
        $this->user = $user;
        $this->bot = app('telegram.bot');
        $this->text = $update->message->text;

        $validator = Validator::make($update->message->toArray(), $this->rules());

        if ($validator->fails()) {
            $this->bot->sendMessage([
                'chat_id' => $this->user->telegram_id,
                'text' => $this->getValidationMessage() ?? implode(', ', $validator->errors()->toArray()),
            ]);
            return;
        }

        $this->handler();
    }

    protected function rules(): array
    {
        return ['text' => $this->rule()];
    }

    protected function getValidationMessage(): ?string
    {
        return null;
    }

    abstract protected function rule(): string|array|ValidationRule;

    abstract protected function handler();
}
