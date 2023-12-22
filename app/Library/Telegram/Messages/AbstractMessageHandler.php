<?php

namespace App\Library\Telegram\Messages;

use App\Contracts\Telegram\TelegramUpdateHandlerContract;
use App\Models\State;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

abstract class AbstractMessageHandler implements TelegramUpdateHandlerContract
{
    protected Update $update;
    protected State $state;
    protected Api $bot;
    protected string $text;

    public function respond(Update $update, State $state): void
    {
        $this->update = $update;
        $this->state = $state;
        $this->bot = app('telegram.bot');
        $this->text = $update->message->text;

        $validator = Validator::make($update->message->toArray(), $this->rules());

        if ($validator->fails()) {
            $this->bot->sendMessage([
                'chat_id' => $this->state->telegram_id,
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
