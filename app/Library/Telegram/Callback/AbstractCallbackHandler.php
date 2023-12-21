<?php

namespace App\Library\Telegram\Callback;

use App\Models\User;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

abstract class AbstractCallbackHandler
{
    protected Update $update;
    protected User $user;
    protected Api $bot;
    protected ?int $message_id;
    protected ?string $data;
    protected ?int $chat_id;
    protected ?int $callback_id;

    public function respond(Update $update, User $user): void
    {
        $this->update = $update;
        $this->user = $user;
        $this->bot = app('telegram.bot');
        $callback_data = trim($update->callback_query->data) ?? '';
        $offset = stripos($callback_data, config('params.callback.handler_separator'));
        $this->data = substr($callback_data, $offset ? $offset + 1: 0);
        $this->message_id = $update->callback_query?->messageId;
        $this->chat_id = $update->callback_query?->chat?->id;
        $this->callback_id = $update->callback_query?->id;

        $this->handler();
    }

    abstract protected function handler();
}
