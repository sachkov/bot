<?php

namespace App\Library\Telegram\Responses;

use App\Library\Enum\StateEnum;
use App\Library\Telegram\Keyboards\InlineKeyboardButton;
use App\Library\Telegram\Keyboards\InlineKeyboardMarkup;
use Illuminate\Contracts\Validation\ValidationRule;

class DefaultResponse extends AbstractResponse
{
    protected function rule(): string|array|ValidationRule
    {
        return ['min:3', 'max:255'];
    }

    protected function respond()
    {
        $result = \PrayService::quickAdd($this->text, $this->user);

        if (!$result) {
            $this->bot->sendMessage([
                'chat_id' => $this->user->telegram_id,
                'text' => 'Saving error. Please try later.',
            ]);
            return;
        }

        $message = 'Молитва сохранена. ' . PHP_EOL . 'По умолчанию она будет активна в течении ';
        $message .= config('params.default.pray_length') .' дней. ';
        $message .= 'Вы можете выбрать время действия молитвы или написать точное количество дней ';
        $message .= 'или написать дату окончания молитвы.';

        $keyboard = new InlineKeyboardMarkup([[
            new InlineKeyboardButton('1', 'period_7'),
            new InlineKeyboardButton('7', 'period_14'),
            new InlineKeyboardButton('30', 'period_30'),
        ]]);

        $this->bot->sendMessage([
            'chat_id'       => $this->user->telegram_id,
            'text'          => $message,
            'reply_markup'  => $keyboard->toJson(),
        ]);

        \StateService::set(StateEnum::ADD_PRAY_TIME, $this->user);
    }

    protected function getValidationMessage(): ?string
    {
        return 'The pray mast be minimum 3 symbols and maximum 255.';
    }
}
