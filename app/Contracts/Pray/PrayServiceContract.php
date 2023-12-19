<?php

namespace App\Contracts\Pray;

use App\Models\Pray;
use App\Models\User;

interface PrayServiceContract
{
    public function saveDescription(string $description, User $user, ?Pray $pray = null): Pray;
    public function changeLength(string $date, Pray $pray): Pray;
    public function quickAdd(string $text, User $user): Pray;
}
