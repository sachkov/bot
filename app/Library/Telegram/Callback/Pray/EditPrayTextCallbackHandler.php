<?php

namespace App\Library\Telegram\Callback\Pray;

use App\Library\Enum\StateEnum;
use App\Library\Telegram\Callback\AbstractCallbackHandler;

class EditPrayTextCallbackHandler extends AbstractCallbackHandler
{
    protected function handler()
    {
        $user = \UserService::getByUpdate($this->update);

        $res = [
            'chat_id' => $this->chat_id,
            'text' => 'Напишите новый текст молитвы и он будет сохранен.',
        ];

        $this->bot->sendMessage($res);

        \StateService::set(StateEnum::EDIT_PRAY_TEXT, $user, ['pray_id' => $this->state?->data['pray']]);

        $this->bot->editMessageReplyMarkup([
            'chat_id'       => $this->chat_id,
            'message_id'    => $this->message_id,
            'reply_markup'  => json_encode(['inline_keyboard' =>[]]),
        ]);
    }
}
