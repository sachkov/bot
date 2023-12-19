<?php

namespace App\Library\Telegram\Keyboards;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class InlineKeyboardMarkup implements Arrayable, Jsonable
{
    public function __construct(array $button_lines)
    {
        foreach ($button_lines as $buttons){
            $line = [];
            foreach ($buttons as $button) {
                $line[] = $button->toArray();
            }
            $this->keyboard[] = $line;
        }
    }

    public function toArray()
    {
        return ['inline_keyboard' => $this->keyboard];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }
}
