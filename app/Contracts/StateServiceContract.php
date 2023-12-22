<?php

namespace App\Contracts;

use App\Library\Enum\StateEnum;
use App\Models\State;
use App\Models\User;
use Telegram\Bot\Objects\Update;

interface StateServiceContract
{
    public function getByTelegramId(int $telegram_id): State;
    public function getByUpdate(Update $update): ?State;
    public function set(StateEnum $handler, User $user, array $data): void;
    public function reset(User $user): void;
    public function getCallbackState($update): State;
}
