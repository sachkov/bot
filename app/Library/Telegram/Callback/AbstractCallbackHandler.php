<?php

namespace App\Library\Telegram\Callback;

use App\Contracts\Telegram\TelegramUpdateHandlerContract;
use App\Models\State;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

abstract class AbstractCallbackHandler implements TelegramUpdateHandlerContract
{
    protected Update $update;
    protected State $state;
    protected Api $bot;
    protected ?int $message_id;
    protected ?int $chat_id;
    protected ?int $callback_id;

    public function respond(Update $update, State $state): void
    {
        $this->update = $update;
        $this->state = $state;
        $this->bot = app('telegram.bot');

        $this->message_id = $update->callback_query?->message->message_id;
        $this->chat_id = $update->callback_query?->chat?->id;
        $this->callback_id = $update->callback_query?->id;

        $this->handler();
    }

    abstract protected function handler();
}
