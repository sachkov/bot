<?php

namespace App\Library\Enum;

use App\Library\Telegram\Callback\DefaultCallbackHandler;

enum CallbackEnum: string
{
    case DEFAULT = DefaultCallbackHandler::class;
    case ADD_PRAY_LENGTH = 'addPrayLengthCb';
    case LIST_PRAY = 'listPrayCb';
    case EDIT_PRAY = 'EPrayCb';
    case EDIT_PRAY_SHOW = 'EPrayShowCb';
    case EDIT_PRAY_TEXT = 'EPrayTextCb';
    case EDIT_PRAY_LENGTH = 'EPrayLenCb';
    case EDIT_PRAY_STOP = 'EPrayStopCb';
}
