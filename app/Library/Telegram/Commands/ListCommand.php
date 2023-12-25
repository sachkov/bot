<?php

namespace App\Library\Telegram\Commands;

use App\Library\Enum\CallbackEnum;
use App\Library\Telegram\Keyboards\InlineKeyboardButton;
use App\Library\Telegram\Keyboards\InlineKeyboardMarkup;
use Telegram\Bot\Commands\Command;

class ListCommand extends Command
{
    protected string $name = 'List';
    protected string $description = 'Get list of prays';

    public function handle()
    {
        $user = \UserService::getByUpdate($this->getUpdate());

        list($text, $next) = \PrayService::list($user, 1);

        $res = ['text' => $text];

        if ($next) {
            $callback_data = [
                'h' => CallbackEnum::LIST_PRAY->value,
                'page' => 2
            ];
            $keyboard = new InlineKeyboardMarkup([[
                new InlineKeyboardButton('next', $callback_data),
            ]]);
            $res['reply_markup'] = $keyboard->toJson();
        }

        $this->replyWithMessage($res);
    }
}
