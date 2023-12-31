<?php

namespace App\Services;

use App\Contracts\StateServiceContract;
use App\Library\Enum\CallbackEnum;
use App\Library\Enum\StateEnum;
use App\Models\State;
use App\Models\User;
use Telegram\Bot\Objects\Update;

class StateService implements StateServiceContract
{
    public function getByTelegramId(int $telegram_id): State
    {
        $state = State::where('telegram_id', $telegram_id)->first();

        if (is_null($state)) {
            $state = $this->getEmptyMessageState($telegram_id);
        }

        $state->handler = $state->handler ?? StateEnum::DEFAULT->value;
        return $state;
    }

    public function getByUpdate(Update $update): ?State
    {
        if ($update->getMessage()->hasCommand()) {
            return null;
        }

        $type = $update->objectType();
        return match ($type) {
            'callback_query' => $this->getCallbackState($update),
            'message' => $this->getByTelegramId($update?->message?->from?->id ?? 0),
            default => $this->getEmptyMessageState(),
        };
    }

    public function set(StateEnum $handler, User $user, array $data): void
    {
        $state = $user->state()->first();

        if (is_null($state)) {
            State::create([
                'telegram_id' => $user->telegram_id,
                'handler' => $handler->value,
                'data' => $data,
            ]);
            return;
        }

        $state->handler = $handler->value;
        $state->data = $data;
        $state->save();
    }

    public function reset(User $user): void
    {
        $state = $user->state()->first();

        if (is_null($state)) {
            return;
        }

        $state->handler = null;
        $state->data = null;
        $state->save();
    }

    public function getCallbackState($update): State
    {
        parse_str($update->callback_query->data, $data);

        $state = new State;
        $state->handler = $data['h'] ?? CallbackEnum::DEFAULT->value;
        $state->telegram_id = $update->callback_query->from->id;
        unset($data['h']);
        $state->data = $data ?? [];

        return $state;
    }

    public function getEmptyMessageState(int $telegram_id = 0): State
    {
        $state = new State;
        $state->handler = StateEnum::DEFAULT->value;
        $state->telegram_id = $telegram_id;
        $state->data = [];
        return $state;
    }
}
