<?php

namespace App\Services;

use App\Contracts\StateServiceContract;
use App\Library\Enum\StateEnum;
use App\Models\State;
use App\Models\User;

class StateService implements StateServiceContract
{
    public function getById(int $telegram_id): string
    {
        $state = State::where('telegram_id', $telegram_id)->value('class');
        return $state ?? StateEnum::DEFAULT->value;
    }

    public function set(StateEnum $state_label, User $user): void
    {
        $state = $user->state()->get();

        if (is_null($state)) {
            State::create([
                'telegram_id' => $user->telegram_id,
                'class' => $state_label->value,
            ]);
            return;
        }

        $state->class = $state_label->value;
        $state->save();
    }

    public function reset(User $user): void
    {
        $state = $user->state()->get();

        if (is_null($state)) {
            return;
        }

        $state->class = null;
        $state->save();
    }
}
