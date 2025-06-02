<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Это модель, которая работает с таблицей achievements

class Achievement extends Model
{
     protected $table = 'achievements';

     protected $fillable = [
        'name',
        'description',
        'intexcoin',
        'image',  
        'required_count'
    ];

    public function users() // users() — метод, который показывает, какие пользователи получили эту ачивку.
    {
         return $this->belongsToMany(\App\Models\User::class,
            'user_achievements',
            'achievement_id',
            'user_id'
        );
        // return $this->belongsToMany(UserAchievement::class, 'user_achievements');
    }
}