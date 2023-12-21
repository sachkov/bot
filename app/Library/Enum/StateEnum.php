<?php

namespace App\Library\Enum;

enum StateEnum: string
{
    case DEFAULT            = 'addPray';
    case ADD_PRAY_DESCR     = 'addPrayDescr';
    case ADD_PRAY_LENGTH      = 'addPrayLength';
}
