<?php

namespace App\Library\Telegram\Messages\Pray;

use App\Library\Telegram\Messages\AbstractMessageHandler;
use App\Models\Pray;
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

        $user = \UserService::getByTelegramId($this->state->telegram_id);

        $pray = Pray::find($this->state->data['pray_id']);

        \PrayService::setLength($pray, $this->text);

        $this->bot->editMessageReplyMarkup([
            'chat_id'       => $user->telegram_id,
            'message_id'    => $this->state->data['message_id'],
            'reply_markup'  => json_encode(['inline_keyboard' =>[]]),
        ]);

        $this->bot->sendMessage([
            'chat_id'       => $user->telegram_id,
            'text'          => 'Сохранено. Молитва активна до ' . $pray->end_date,
        ]);

        \StateService::reset($user);
    }
}
