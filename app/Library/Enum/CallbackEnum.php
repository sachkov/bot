<?php

namespace App\Library\Enum;

use App\Library\Telegram\Callback\DefaultCallbackHandler;

enum CallbackEnum: string
{
    case DEFAULT = DefaultCallbackHandler::class;
    case ADD_PRAY_LENGTH = 'addPrayLengthCb';
    case LIST_PRAY = 'listPrayCb';
}
