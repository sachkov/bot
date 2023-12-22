<?php

namespace App\Facades\User;

use App\Contracts\User\UserServiceContract;
use Illuminate\Support\Facades\Facade;

class UserServiceFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return UserServiceContract::class;
    }
}
