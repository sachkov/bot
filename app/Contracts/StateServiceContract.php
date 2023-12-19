<?php

namespace App\Contracts;

use App\Library\Enum\StateEnum;
use App\Models\User;

interface StateServiceContract
{
    public function getById(int $telegram_id): string;
    public function set(StateEnum $state_label, User $user): void;
}
