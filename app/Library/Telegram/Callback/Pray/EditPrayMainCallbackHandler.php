<?php

namespace App\Library\Telegram\Callback\Pray;

use App\Library\Telegram\Callback\AbstractCallbackHandler;

class EditPrayMainCallbackHandler extends AbstractCallbackHandler
{
    protected function handler()
    {
        $user = \UserService::getByUpdate($this->update);

        $page = $this->state?->data['page'] ?? 1;

        $res = \PrayService::getEditMessage($user, $page);

        $res['chat_id'] = $this->chat_id;

        $this->bot->sendMessage($res);

        $this->bot->editMessageReplyMarkup([
            'chat_id'       => $this->chat_id,
            'message_id'    => $this->message_id,
            'reply_markup'  => json_encode(['inline_keyboard' =>[]]),
        ]);
    }
}
