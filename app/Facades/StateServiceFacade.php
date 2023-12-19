<?php

namespace App\Facades;

use App\Contracts\StateServiceContract;
use Illuminate\Support\Facades\Facade;

class StateServiceFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return StateServiceContract::class;
    }
}
