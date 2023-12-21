<?php

namespace App\Contracts\Pray;

use App\Models\Pray;
use App\Models\User;

interface PrayServiceContract
{
    public function saveDescription(string $description, User $user, ?Pray $pray = null): Pray;
    public function setLength(Pray $pray, string $date): Pray;
    public function increaseLength(Pray $pray, string $date): Pray
    public function quickAdd(string $text, User $user): Pray;
}
