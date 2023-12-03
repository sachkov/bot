<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTelegramSecretToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = config('telegram.bots.pray_bot.secret_token');
        if ($request->headers->get('X-Telegram-Bot-Api-Secret-Token') !== $token) {
            return response()->json([
                'message' => 'Bad request.'
            ], Response::HTTP_BAD_REQUEST);
        }
        return $next($request);
    }
}
