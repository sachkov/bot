<?php

namespace App\Library\Telegram\Callback;

class DefaultCallbackHandler extends AbstractCallbackHandler
{
    /**
     * A handler for an emergency situation when it is unclear which callback came.
     * @return void
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function handler()
    {
        if (!is_null($this->callback_id)) {
            $this->bot->answerCallbackQuery([
                'callback_query_id' => $this->callback_id,
                'text'              => 'Ошибка чтения данных',
            ]);
        }

        if (!is_null($this->message_id) && !is_null($this->chat_id)) {
            $this->bot->editMessageReplyMarkup([
                'chat_id'       => $this->chat_id,
                'message_id'    => $this->message_id,
                'reply_markup'  => json_encode(['inline_keyboard' =>[]]),
            ]);
        }
    }
}
