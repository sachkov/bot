<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function update(Request $request)
    {
        Log::debug('Tel controller', [$request->all()]);
        Telegram::commandsHandler(true);

        return response()->json(true, ResponseAlias::HTTP_OK);
    }
}
