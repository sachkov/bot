<?php

namespace App\Library\Telegram\Callback\Pray;

use App\Library\Enum\CallbackEnum;
use App\Library\Telegram\Callback\AbstractCallbackHandler;
use App\Library\Telegram\Keyboards\InlineKeyboardButton;
use App\Library\Telegram\Keyboards\InlineKeyboardMarkup;

class ListPrayCallbackHandler extends AbstractCallbackHandler
{
    protected function handler()
    {
        $user = \UserService::getByUpdate($this->update);

        $page = $this->state?->data['page'] ?? 1;

        list($text, $next) = \PrayService::list($user, $page);

        $res = ['text' => $text];

        if ($next) {
            $callback_data = [
                'h' => CallbackEnum::LIST_PRAY->value,
                'page' => $page + 1
            ];
            $keyboard = new InlineKeyboardMarkup([[
                new InlineKeyboardButton('next', $callback_data),
            ]]);
            $res['reply_markup'] = $keyboard->toJson();
        }

        $this->bot->sendMessage($res);

        $this->bot->editMessageReplyMarkup([
            'chat_id'       => $this->chat_id,
            'message_id'    => $this->message_id,
            'reply_markup'  => json_encode(['inline_keyboard' =>[]]),
        ]);
    }
}
