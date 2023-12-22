<?php

namespace App\Library\Telegram\Messages;

use App\Library\Enum\CallbackEnum;
use App\Library\Enum\StateEnum;
use App\Library\Telegram\Keyboards\InlineKeyboardButton;
use App\Library\Telegram\Keyboards\InlineKeyboardMarkup;
use Illuminate\Contracts\Validation\ValidationRule;

class DefaultMessageHandler extends AbstractMessageHandler
{
    protected function rule(): string|array|ValidationRule
    {
        return ['min:3', 'max:255'];
    }

    protected function handler()
    {
        $user = \UserService::getByUpdate($this->update);
        $result = \PrayService::quickAdd($this->text, $user);

        if (!$result) {
            $this->bot->sendMessage([
                'chat_id' => $user->telegram_id,
                'text' => 'Saving error. Please try later.',
            ]);
            return;
        }

        $message = 'Молитва сохранена. ' . PHP_EOL . 'По умолчанию она будет активна в течении ';
        $message .= config('params.default.pray_length') .' дней. ';
        $message .= 'Вы можете выбрать другое время действия молитвы или написать точное количество дней ';
        $message .= 'или написать дату окончания молитвы.';

        $keyboard = new InlineKeyboardMarkup([[
            new InlineKeyboardButton('1', $this->makeCallbackData(1, $result->id)),
            new InlineKeyboardButton('7', $this->makeCallbackData(7, $result->id)),
            new InlineKeyboardButton('30', $this->makeCallbackData(30, $result->id)),
        ]]);

        $message = $this->bot->sendMessage([
            'chat_id'       => $user->telegram_id,
            'text'          => $message,
            'reply_markup'  => $keyboard->toJson(),
        ]);

        $data = [
            'message_id' => $message?->messageId,
            'pray_id'    => $result->id,
        ];

        \StateService::set(StateEnum::ADD_PRAY_LENGTH, $user, $data);
    }

    protected function getValidationMessage(): ?string
    {
        return 'The pray mast be minimum 3 symbols and maximum 255.';
    }

    protected function makeCallbackData(int $period, int $pray_id): array
    {
        return [
            'handler' => CallbackEnum::ADD_PRAY_LENGTH->value,
            'data' => [
                'period_days' => $period,
                'pray_id' => $pray_id,
            ],
        ];
    }
}
