<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// в процессе разработки
class UserAchievement extends Model
{
    
    protected $fillable = ['intexcoin'];

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements');
    }

    public function addCoins(int $amount)
    {
        $this->coins += $amount;
        $this->save();
    }
}
