<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Telegram\Bot\Laravel\Facades\Telegram;
use TelegramService;

class TelegramController extends Controller
{
    public function update(Request $request)
    {
        Log::debug('Tel controller1');
        $update = Telegram::commandsHandler(true);
        Log::debug('Tel controller2', [$update->getMessage(), $update->getMessage()->hasCommand()]);

        TelegramService::respond($update);

        return response()->json(true, ResponseAlias::HTTP_OK);
    }
}
