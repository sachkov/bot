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
        $update = Telegram::commandsHandler(true);

        TelegramService::respond($update);

        return response()->json(true, ResponseAlias::HTTP_OK);
    }
}
