<?php

namespace App\Library\Telegram\Commands;

use App\Library\Enum\CallbackEnum;
use App\Library\Telegram\Keyboards\InlineKeyboardButton;
use App\Library\Telegram\Keyboards\InlineKeyboardMarkup;
use Telegram\Bot\Commands\Command;

class EditCommand extends Command
{
    protected string $name = 'Edit';
    protected string $description = 'Start pray edit dialog';

    public function handle()
    {
        $user = \UserService::getByUpdate($this->getUpdate());

        $res = \PrayService::getEditMessage($user, 1);

        $this->replyWithMessage($res);
    }
}
