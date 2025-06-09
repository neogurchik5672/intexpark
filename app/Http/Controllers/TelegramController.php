<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TelegramController extends Controller
{
    public function handle(Request $request)
    {
        $message = $request['message'] ?? null;
        if (!$message) return response('ok', 200);

        $chat_id = $message['chat']['id'];
        $username = $message['from']['username'] ?? $message['from']['first_name'];
        $telegram_id = $message['from']['id'] ?? null;
        $text = trim($message['text'] ?? '');

        Log::info('Обработка Telegram-сообщения', [
            'telegram_id' => $telegram_id,
            'username' => $username,
            'полное_сообщение' => $message
        ]);

        if ($text === '/start') {
            $this->sendMessage($chat_id, "Привет! Отправляю ссылку для входа...");

            if (!$telegram_id) {
                Log::warning('Пропущено создание пользователя: отсутствует telegram_id');
                return response('ok', 200);
            }

            $token = Str::uuid();

            // Найти пользователя по telegram_id
            $user = User::where('telegram_id', $telegram_id)->first();

            if (!$user) {
                // Создание нового пользователя
                $user = User::create([
                    'telegram_id' => $telegram_id,
                    'username' => $username ?? null,
                    'balance' => 0,
                    'login_token' => $token,
                    'login_token_expires_at' => Carbon::now()->addMinutes(5)
                ]);
                Log::info('Создан новый пользователь', ['user_id' => $user->id]);
            } else {
                // Обновление токена существующего пользователя
                $user->update([
                    'login_token' => $token,
                    'login_token_expires_at' => Carbon::now()->addMinutes(5)
                ]);
                Log::info('Обновлён токен пользователя', ['user_id' => $user->id]);
            }

            $url = url("/auth/telegram/token/$token");
            $this->sendMessage($chat_id, "Нажми сюда для входа: $url");
        }

        return response('ok', 200);
    }

  private function sendMessage($chat_id, $text)
{
    Log::info('Отправка сообщения в Telegram', ['chat_id' => $chat_id, 'text' => $text]);

    $token = env('TELEGRAM_BOT_TOKEN');
    $response = Http::post("https://api.telegram.org/bot$token/sendMessage", [
        'chat_id' => $chat_id,
        'text' => $text
    ]);

    Log::info('Ответ Telegram API', ['response' => $response->json()]);
}
}
