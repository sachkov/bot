<?php

namespace App\Library\Telegram\Commands;

use App\Library\Enum\StateEnum;
use Telegram\Bot\Commands\Command;

class AddCommand extends Command
{
    protected string $name = 'Add';
    protected string $description = 'Adding new prayer.';

    public function handle()
    {
        $user = \TelegramService::getUser($this->getUpdate());

        $res = [
            'text' => '
                Опишите текст молитвы в новом сообщении, длинной до 255 символов и я сохраню его.
            ',
        ];

        $this->replyWithMessage($res);

        \StateService::set(StateEnum::DEFAULT, $user);
    }
}
