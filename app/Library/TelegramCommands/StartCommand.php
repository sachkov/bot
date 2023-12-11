<?php

namespace App\Library\TelegramCommands;

use Illuminate\Support\Facades\Log;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Login in IDPRO app';

    public function handle()
    {
//        $button = [
//            "text" => "JOIN",
//            "login_url" => [
//                "url" => config('app.frontend_url') . config('telegram.bots.mybot.redirect_path'),
//                "request_write_access" => true,
//            ]
//        ];
//        $keyboard = [
//            [$button],
//        ];
//
//        $reply_markup = [
//            "inline_keyboard" => $keyboard
//        ];

        Log::debug('telegram command',
            [
                'updateObj'=>$this->getUpdate(),
                'MessageObj'=>$this->getUpdate()->getMessage()
            ]
        );


        $this->replyWithMessage([
            'text' => 'I got it!',
        ]);
    }
}
