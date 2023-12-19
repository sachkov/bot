<?php

namespace App\Library\Telegram\Commands;

use App\Library\Telegram\Keyboards\ReplyKeyboardMarkup;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Login in Pray bot';

    public function handle()
    {
        $keyboard = (new ReplyKeyboardMarkup([['Add', 'Settings']]))->setPersistent(true);
        $res = [
            'text' => '
                Добро пожаловать.
                Я помогаю сохранить и упорядочевать ваши молитвы, делится ими с друзьями и многое другое.
                Создавайте новые молитвы просто написав об этом в чат и просматривайте когда будет необходимо.
            ',
        ];

        $this->replyWithMessage(array_merge($res, $keyboard->toArray()));
    }
}
