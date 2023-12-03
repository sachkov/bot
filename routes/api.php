<?php

use App\Http\Controllers\TelegramController;
use App\Http\Middleware\CheckTelegramSecretToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::controller(TelegramController::class)->group(function () {
    Route::post('/telegram/webhook', 'update')
        ->middleware([CheckTelegramSecretToken::class]);
});
