<?php

namespace App\Facades\Pray;

use App\Contracts\Pray\PrayServiceContract;
use Illuminate\Support\Facades\Facade;

class PrayServiceFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return PrayServiceContract::class;
    }
}
