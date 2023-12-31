<?php

namespace App\Contracts\Pray;

use App\Models\Pray;
use App\Models\User;
use Illuminate\Database\Query\Builder;

interface PrayServiceContract
{
    public function saveDescription(string $description, User $user, ?Pray $pray = null): Pray;
    public function setLength(Pray $pray, string $date): Pray;
    public function increaseLength(Pray $pray, string $date): Pray;
    public function quickAdd(string $text, User $user): Pray;
    public function list(User $user, int $page=1): array;
    public function getEditMessage(User $user, int $page=1): array;
}
