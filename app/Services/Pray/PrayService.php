<?php

namespace App\Services\Pray;

use App\Contracts\Pray\PrayServiceContract;
use App\Models\Pray;

class PrayService implements PrayServiceContract
{
    public function saveDescription(Pray $pray, string $description): Pray
    {

    }

    public function changeLength(Pray $pray, int $days): Pray
    {

    }
}
