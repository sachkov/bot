<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function update()
    {
        Telegram::commandsHandler(true);

        return response()->json(true, ResponseAlias::HTTP_OK);
    }
}
