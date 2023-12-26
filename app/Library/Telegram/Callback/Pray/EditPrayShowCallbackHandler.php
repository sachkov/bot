<?php

namespace App\Library\Telegram\Callback\Pray;

use App\Library\Enum\CallbackEnum;
use App\Library\Telegram\Callback\AbstractCallbackHandler;
use App\Library\Telegram\Keyboards\InlineKeyboardButton;
use App\Library\Telegram\Keyboards\InlineKeyboardMarkup;
use App\Models\Pray;

class EditPrayShowCallbackHandler extends AbstractCallbackHandler
{
    protected function handler()
    {
        $user = \UserService::getByUpdate($this->update);

        $pray_id = $this->state?->data['pray'] ?? 0;

        $pray = Pray::find($pray_id);

        if (is_null($pray) || $pray->author_id != $user->id) {
            $this->bot->sendMessage([
                'chat_id' => $this->chat_id,
                'text' => 'Ошибка получения политвы.',
            ]);
        }

        $text = $pray->description . PHP_EOL;
        $text .= 'Что меняем?';

        $keyboard = new InlineKeyboardMarkup([[
            new InlineKeyboardButton('text', [
                'h' => CallbackEnum::EDIT_PRAY_TEXT->value,
                'pray' => $pray->id,
            ]),
            new InlineKeyboardButton('extend', [
                'h' => CallbackEnum::EDIT_PRAY_LENGTH->value,
                'pray' => $pray->id,
            ]),
            new InlineKeyboardButton('complete', [
                'h' => CallbackEnum::EDIT_PRAY_STOP->value,
                'pray' => $pray->id,
            ]),
        ]]);

        $res = [
            'chat_id' => $this->chat_id,
            'text' => $text,
            'reply_markup' => $keyboard->toJson(),
        ];

        $this->bot->sendMessage($res);

        //delete last message keyboard
        $this->bot->editMessageReplyMarkup([
            'chat_id'       => $this->chat_id,
            'message_id'    => $this->message_id,
            'reply_markup'  => json_encode(['inline_keyboard' =>[]]),
        ]);
    }
}
