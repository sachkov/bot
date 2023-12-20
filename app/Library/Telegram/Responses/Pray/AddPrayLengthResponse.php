<?php

namespace App\Library\Telegram\Responses\Pray;

use App\Library\Telegram\Responses\AbstractResponse;
use Illuminate\Contracts\Validation\ValidationRule;

class AddPrayLengthResponse extends AbstractResponse
{
    protected function rule(): string|array|ValidationRule
    {
        return [];
    }

    protected function respond()
    {
        \Log::debug('AddPrayLengthResponse');
    }
}
