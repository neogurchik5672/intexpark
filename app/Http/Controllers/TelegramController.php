<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TelegramController extends Controller
{
    public function handle(Request $request)
    {
        $message = $request['message'] ?? null;
        if (!$message) return response('ok', 200);

//   \Log::info('Telegram user data:', [
//         'telegram_id' => $message['from']['id'] ?? null,
//         'username' => $message['from']['username'] ?? null,
//         'full_message_data' => $message['from'] ?? null
//     ]);
    
        $chat_id = $message['chat']['id'];
  $username = $message['from']['username'] ?? $message['from']['first_name'];
        $telegram_id = $message['from']['id'] ?? null;
        $text = trim($message['text'] ?? '');

        if ($text === '/start') {
            $this->sendMessage($chat_id, "Привет! Отправляю ссылку для входа...");

            $token = Str::uuid();
          $user = User::updateOrCreate(
        ['telegram_id' => $telegram_id],
        [
            'username' => $username ?? null, 
            'balance' => 0,
            'login_token' => $token,
            'login_token_expires_at' => Carbon::now()->addMinutes(5)
        ]
    );

    $url = url("/auth/telegram/token/$token");
    $this->sendMessage($chat_id, "Нажми сюда для входа: $url");
        }

        return response('ok', 200);
    }

    private function sendMessage($chat_id, $text)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        Http::post("https://api.telegram.org/bot$token/sendMessage", [
            'chat_id' => $chat_id,
            'text' => $text
        ]);
    }
}
