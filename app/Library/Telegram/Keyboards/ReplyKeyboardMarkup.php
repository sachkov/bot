<?php

namespace App\Library\Telegram\Keyboards;

use Illuminate\Contracts\Support\Arrayable;

class ReplyKeyboardMarkup implements Arrayable
{
    private array $keyboard;
    private bool $is_persistent;
    private bool $resize_keyboard;
    private bool $one_time_keyboard;
    private string $input_field_placeholder;
    private bool $selective;


    public function __construct(array $button_lines)
    {
        foreach ($button_lines as $buttons){
            $line = [];
            foreach ($buttons as $button) {
                if (is_string($button)) {
                    $line[] = ['text' => $button];
                } else {
                    $line[] = $button->toArray();
                }
            }
            $this->keyboard[] = $line;
        }
    }

    public function setPersistent(bool $val): self
    {
        $this->is_persistent = $val;
        return $this;
    }

    public function setResize(bool $val): self
    {
        $this->resize_keyboard = $val;
        return $this;
    }

    public function setOneTime(bool $val): self
    {
        $this->one_time_keyboard = $val;
        return $this;
    }

    public function setPlaceholder(string $val): self
    {
        $this->input_field_placeholder = $val;
        return $this;
    }

    public function setSelective(bool $val): self
    {
        $this->selective = $val;
        return $this;
    }

    public function toArray(): array
    {
        $res = ['keyboard' => $this->keyboard];

        if (isset($this->is_persistent)) {
            $res['is_persistent'] = $this->is_persistent;
        }

        if (isset($this->resize_keyboard)) {
            $res['resize_keyboard'] = $this->is_persistent;
        }

        if (isset($this->one_time_keyboard)) {
            $res['one_time_keyboard'] = $this->is_persistent;
        }

        if (isset($this->input_field_placeholder)) {
            $res['input_field_placeholder'] = $this->is_persistent;
        }

        if (isset($this->selective)) {
            $res['selective'] = $this->is_persistent;
        }

        return $res;
    }
}
