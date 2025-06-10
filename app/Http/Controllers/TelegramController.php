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
        Log::debug('Входящий запрос от Telegram', ['request' => $request->all()]);

        $message = $request['message'] ?? null;
        if (!$message) {
            Log::debug('Пустое сообщение');
            return response('ok', 200);
        }

        $chat_id = $message['chat']['id'] ?? null;
        $username = $message['from']['username'] ?? $message['from']['first_name'] ?? 'unknown';
        $telegram_id = $message['from']['id'] ?? null;
        $text = trim($message['text'] ?? '');

        if (!$chat_id || !$telegram_id) {
            Log::error('Не хватает обязательных данных', [
                'chat_id' => $chat_id,
                'telegram_id' => $telegram_id
            ]);
            return response('ok', 200);
        }

        Log::info('Обработка Telegram-сообщения', [
            'telegram_id' => $telegram_id,
            'username' => $username,
            'message_text' => $text
        ]);

        if ($text === '/start') {
            $this->sendWelcomeMessage($chat_id, $telegram_id, $username);
        }

        return response('ok', 200);
    }

    private function sendWelcomeMessage($chat_id, $telegram_id, $username)
    {
        try {
            // Отправляем приветственное сообщение
            $this->sendTelegramMessage($chat_id, "Привет, $username! Отправляю ссылку для входа...");

            // Создаем или обновляем пользователя
            $token = Str::uuid();
            $user = User::updateOrCreate(
                ['telegram_id' => $telegram_id],
                [
                    'username' => $username,
                    'login_token' => $token,
                    'login_token_expires_at' => Carbon::now()->addMinutes(5),
                    'balance' => 0
                ]
            );

            Log::info('Пользователь обработан', [
                'user_id' => $user->id,
                'action' => $user->wasRecentlyCreated ? 'created' : 'updated'
            ]);

            // Отправляем сообщение с ссылкой
            $url = url("/auth/telegram/token/$token");
            $this->sendTelegramMessage($chat_id, "Нажмите для входа: $url");

        } catch (\Exception $e) {
            Log::error('Ошибка обработки команды /start', [
                'chat_id' => $chat_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function sendTelegramMessage($chat_id, $text)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        if (empty($token)) {
            Log::error('Отсутствует TELEGRAM_BOT_TOKEN');
            return false;
        }

        try {
            $response = Http::timeout(10)
                ->retry(3, 100)
                ->post("https://api.telegram.org/bot{$token}/sendMessage", [
                    'chat_id' => $chat_id,
                    'text' => $text,
                    'parse_mode' => 'HTML'
                ]);

            $responseData = $response->json();

            if ($response->successful() && ($responseData['ok'] ?? false)) {
                Log::debug('Сообщение успешно отправлено', [
                    'chat_id' => $chat_id,
                    'message_id' => $responseData['result']['message_id'] ?? null
                ]);
                return true;
            }

            Log::error('Ошибка отправки сообщения', [
                'chat_id' => $chat_id,
                'response' => $responseData,
                'status' => $response->status()
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('Исключение при отправке сообщения', [
                'chat_id' => $chat_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
}
