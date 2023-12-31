<?php

namespace App\Library\Telegram\Keyboards;

use Illuminate\Contracts\Support\Arrayable;

class InlineKeyboardButton implements Arrayable
{
    private ?string $url;

    public function __construct(
        private readonly string $text,
        private readonly array $callback_data = []
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
            $res['callback_data'] = http_build_query($this->callback_data);
        }

        return $res;
    }
}
