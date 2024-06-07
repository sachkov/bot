<?php

namespace App\Library\Enum;

enum StateEnum: string
{
    case DEFAULT                = 'addPray';
    case ADD_PRAY_LENGTH        = 'addPrayLength';
    case EDIT_PRAY_TEXT         = 'editPrayText';
}
