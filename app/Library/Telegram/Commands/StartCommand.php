<?php

namespace App\Library\Telegram\Commands;

use App\Library\Enum\StateEnum;
use App\Library\Telegram\Keyboards\ReplyKeyboardMarkup;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Login in Pray bot';

    public function handle()
    {
        $user = \UserService::getByUpdate($this->getUpdate());

        $keyboard = (new ReplyKeyboardMarkup([['/Add', '/List', '/Edit', '/Settings']]))
            ->setPersistent(true)
            ->setResize(true);

        $message = 'Добро пожаловать ' . $user->name . '.' . PHP_EOL . 'Я помогаю сохранить ';
        $message .= 'и упорядочевать ваши молитвы, делится ими с друзьями и многое другое. ';
        $message .= 'Создавайте новые молитвы просто написав сообщение в чат и просматривайте когда удобно.';

        $res = [
            'text' => $message,
            'reply_markup'  => $keyboard->toJson(),
        ];

        $message = $this->replyWithMessage($res);

        \StateService::set(StateEnum::DEFAULT, $user, ['message_id' => $message?->messageId]);
    }
}
