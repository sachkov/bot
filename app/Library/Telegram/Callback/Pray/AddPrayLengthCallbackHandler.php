<?php

namespace App\Library\Telegram\Callback\Pray;

use App\Library\Telegram\Callback\AbstractCallbackHandler;
use App\Models\Pray;

class AddPrayLengthCallbackHandler extends AbstractCallbackHandler
{
    protected function handler()
    {
        $data = $this->state->data;

        $pray = Pray::find($data['pray_id']);

        $pray = \PrayService::setLength($pray, $data['period_days']);

        $this->bot->answerCallbackQuery([
            'callback_query_id' => $this->callback_id,
            'text'              => 'Сохранено. Молитва активна до ' . $pray->end_date,
        ]);

        if (!is_null($this->chat_id)) {
            $user = \UserService::getByTelegramId((int)$this->chat_id);
            \StateService::reset($user);
        }

        if (!is_null($this->chat_id) && !is_null($this->message_id)) {
            $this->bot->editMessageReplyMarkup([
                'chat_id'       => $this->chat_id,
                'message_id'    => $this->message_id,
                'reply_markup'  => json_encode(['inline_keyboard' =>[]]),
            ]);
        }



    }
}
