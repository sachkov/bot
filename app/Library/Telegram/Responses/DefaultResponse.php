<?php

namespace App\Library\Telegram\Responses;

use Illuminate\Contracts\Validation\ValidationRule;

class DefaultResponse extends AbstractResponse
{
    protected function rule(): string|array|ValidationRule
    {
        return ['min:3', 'max:255'];
    }

    protected function respond()
    {
        $result = \PrayService::quickAdd($this->text, $this->user);

        $message = 'Your prayer was saved.';
        if (!$result) {
            $message = 'Saving error. Please try later.';
        }

        $this->bot->sendMessage([
            'chat_id' => $this->user->telegram_id,
            'text' => $message,
        ]);
    }

    protected function getValidationMessage(): ?string
    {
        return 'The pray mast be minimum 3 symbols and maximum 255.';
    }
}
