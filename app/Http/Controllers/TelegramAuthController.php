<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramAuthController extends Controller
{
    public function autoAuth(Request $request)
    {
        // Получаем данные от Telegram WebApp
        $initData = $request->input('initData');
        
        if (empty($initData)) {
            return response()->json(['error' => 'Telegram auth data missing'], 401);
        }

        parse_str($initData, $data);

        // Проверяем хэш авторизации
        if (!$this->validateTelegramAuth($data)) {
            return response()->json(['error' => 'Invalid Telegram auth data'], 401);
        }

        // Ищем пользователя или создаем нового
        $user = $this->findOrCreateUser($data['user']);

        // Авторизуем пользователя
        Auth::login($user, true);

        return response()->json([
            'status' => 'success',
            'user' => $user
        ]);
    }

    protected function validateTelegramAuth(array $data): bool
    {
        if (!isset($data['hash'])) {
            return false;
        }

        $botToken = config('telegram.bot_token');
        $checkHash = $data['hash'];
        unset($data['hash']);
        
        $dataCheckArr = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
            }
            $dataCheckArr[] = $key . '=' . $value;
        }
        
        sort($dataCheckArr);
        $dataCheckString = implode("\n", $dataCheckArr);
        $secretKey = hash('sha256', $botToken, true);
        $hash = hash_hmac('sha256', $dataCheckString, $secretKey);
        
        return strcmp($hash, $checkHash) === 0;
    }

    protected function findOrCreateUser(array $userData): User
    {
        return User::updateOrCreate(
            ['telegram_id' => $userData['id']],
            [
                'first_name' => $userData['first_name'] ?? null,
                'last_name' => $userData['last_name'] ?? null,
                'username' => $userData['username'] ?? null,
                'photo_url' => $userData['photo_url'] ?? null,
                'auth_date' => $userData['auth_date'] ?? null,
                'hash' => $userData['hash'] ?? null,
                'role' => 'user',
                'balance' => '0',
                'password' => bcrypt(Str::random(16)), // Генерируем случайный пароль
            ]
        );
    }

    public function getUser(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'isAuthenticated' => Auth::check()
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['status' => 'success']);
    }
}