<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'user_id',
        'type',
        'name',
        'desc',
        'count',
        'subject',
        'salary',
        'data',
        'time',
    ];
    public function members(){
        return $this->hasMany(Member::class);
    }
    public function checkevents(){
        return $this->hasOne(CheckEvent::class);
    }
} 
