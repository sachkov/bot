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
        $user = \TelegramService::getUser($this->getUpdate());

        $keyboard = (new ReplyKeyboardMarkup([['/Add', '/List', '/Edit', '/Settings']]))->setPersistent(true);
        $res = [
            'text' => '
                Добро пожаловать ' . $user->name . '.
                Я помогаю сохранить и упорядочевать ваши молитвы, делится ими с друзьями и многое другое.
                Создавайте новые молитвы просто написав об этом в чат и просматривайте когда будет необходимо.
            ',
            'reply_markup'  => $keyboard->toArray(),
        ];

        $this->replyWithMessage($res);
    }
}
