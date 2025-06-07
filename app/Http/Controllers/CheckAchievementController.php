<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\UserAchievement;
use Illuminate\Support\Facades\Auth;
use App\Models\History;
use App\Models\User;

class CheckAchievementController extends Controller
{
    private function getCurrentUser()
    {
        return Auth::user();
    }

    // Проверяем, получил ли пользователь эту ачивку раньше
    private function hasUserAchievement($user, $achievement): bool
    {
        return UserAchievement::where('user_id', $user->id)
                                ->where('achievement_id', $achievement->id)
                                ->exists();
    }

    // Ачивка: "Давно тебя не было в уличных гонках"
    public function checkLongAbsence()
    {
        // Получаем пользователя
        $user = $this->getCurrentUser();

        if (!$user) {
            return false;
        }

        $achievement = Achievement::where('name', 'Давно тебя не было в уличных гонках')->first();

        if (!$achievement || $this->hasUserAchievement($user, $achievement)) {
            return false;
        }

        // Проверяем, прошло ли больше 2 дней с последнего посещения
        if ($user->last_visit && now()->diffInDays($user->last_visit) >= 2) {

            UserAchievement::create([
                'user_id' => $user->id,
                'achievement_id' => $achievement->id,
            ]);

            $this->addIntexCoinUser();
            return true;
        }

        return false;
    }

    // Ачивка "В отрыве от реальности"
    public function checkTotalTimeSpent()
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return false;
        }

        $achievement = Achievement::where('name', 'В отрыве от реальности')->first();

        if (!$achievement || $this->hasUserAchievement($user, $achievement)) {
            return false;
        }

        $hoursSpent = floor($user->total_time_spent / 60);
        if ($hoursSpent >= $achievement->required_count) {
            UserAchievement::create([
                'user_id' => $user->id,
                'achievement_id' => $achievement->id,
            ]);

            $this->addIntexCoinUser();
            return true;
        }
        return false;
    }

    // У каджита есть товар
    public function checkFirstPurchase()
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return false;
        }

        $achievement = Achievement::where('name', 'У каджита есть товар')->first();

        if (!$achievement || $this->hasUserAchievement($user, $achievement)) {
            return false;
        }

        $hasFirstPurchase = History::where('user_id', $user->id)->where('status', 'buy')->exists();

        if ($hasFirstPurchase) {
            UserAchievement::create([
                'user_id' => $user->id,
                'achievement_id' => $achievement->id,
            ]);

            $this->addIntexCoinUser();
            return true;
        }

        return false;
    }

    public function checkThreePurchase()
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return false;
        }

        $achievement = Achievement::where('name', 'Motherlode')->first();

        if (!$achievement || $this->hasUserAchievement($user, $achievement)) {
            return false;
        }

        $purchaseCount = History::where('user_id', $user->id)->where('status', 'buy')->count();

        if ($purchaseCount >= $achievement->required_count) {
            UserAchievement::create([
                'user_id' => $user->id,
                'achievement_id' => $achievement->id,
            ]);
            
            $this->addIntexCoinUser();
            return true;
        }

        return false;
    }

    // Тодд Говард
    public function checkIsFirstMerchPurchase()
    {  
        $user = $this->getCurrentUser();
            
        if (!$user) {
            return false;
        }

        $achievement = Achievement::where('name', 'Тодд Говард')->first();
        
        if (!$achievement || $this->hasUserAchievement($user, $achievement)) {
            return false;
        }

        $merchPurchasesCount = History::where('user_id', $user->id)->where('status', 'buy')
        ->whereHas('product', fn ($q) => $q->where('is_merch', true))->count();

        if ($merchPurchasesCount >= $achievement->required_count) {
            UserAchievement::create([
                'user_id' => $user->id,
                'achievement_id' => $achievement->id,
            ]);

            $this->addIntexCoinUser();
            return true;
        }

        return false;
    }
}