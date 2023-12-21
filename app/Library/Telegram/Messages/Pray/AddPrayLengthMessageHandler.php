<?php

namespace App\Library\Telegram\Messages\Pray;

use App\Library\Telegram\Messages\AbstractMessageHandler;
use Illuminate\Contracts\Validation\ValidationRule;

class AddPrayLengthMessageHandler extends AbstractMessageHandler
{
    protected function rule(): string|array|ValidationRule
    {
        return [];
    }

    protected function handler()
    {
        \Log::debug('AddPrayLengthResponse');

        $pray = \PrayService::setLength($pray, $data);

        $this->bot->editMessageReplyMarkup([
            'chat_id'       => $this->chat_id,
            'message_id'    => $this->message_id,
            'reply_markup'  => json_encode(['inline_keyboard' =>[]]),
        ]);
    }
}
