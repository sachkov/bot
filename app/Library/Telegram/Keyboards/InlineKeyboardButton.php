<?php

namespace App\Library\Telegram\Keyboards;

use App\Library\Enum\CallbackEnum;
use Illuminate\Contracts\Support\Arrayable;

class InlineKeyboardButton implements Arrayable
{
    private ?string $url;

    public function __construct(
        private readonly string $text,
        private readonly CallbackEnum $handler = CallbackEnum::DEFAULT,
        private readonly string|int $callback_data = ''
    ) {
    }

    public function setUrl(string $url) :self
    {
        $this->url = $url;
        return $this;
    }

    public function toArray()
    {
        $res = ['text' => $this->text];

        if (isset($this->url)) {
            $res['url'] = $this->url;
        }

        if ($this->callback_data) {
            $res['callback_data'] = $this->handler->value . config('params.callback.handler_separator');
            $res['callback_data'] .= $this->callback_data;
        }

        return $res;
    }
}
