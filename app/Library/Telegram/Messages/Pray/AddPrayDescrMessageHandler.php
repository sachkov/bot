<?php

namespace App\Library\Telegram\Messages\Pray;

use App\Library\Telegram\Messages\AbstractMessageHandler;
use Illuminate\Contracts\Validation\ValidationRule;

class AddPrayDescrMessageHandler extends AbstractMessageHandler
{
    protected function rule(): string|array|ValidationRule
    {
        return [];
    }

    protected function handler()
    {
        \Log::debug('AddPrayDescrResponse');
    }
}
