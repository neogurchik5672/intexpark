<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Http\Controllers\TelegramController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/telegram/webhook', [TelegramController::class, 'handle'])
    ->withoutMiddleware([
        \App\Http\Middleware\Header::class,
        \App\Http\Middleware\Authenticate::class,
        \App\Http\Middleware\VerifyCsrfToken::class
    ]);
