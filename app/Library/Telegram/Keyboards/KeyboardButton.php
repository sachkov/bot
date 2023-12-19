<?php

namespace App\Library\Telegram\Keyboards;

use Illuminate\Contracts\Support\Arrayable;

class KeyboardButton implements Arrayable
{
    public function __construct(private readonly string $text)
    {
    }

    public function toArray(): array
    {
        return ['text' => $this->text];
    }
}
