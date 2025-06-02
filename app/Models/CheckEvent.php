<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckEvent extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'user_id',
        'events_id',
        'status',
    ];
    public function events(){
        return $this->belongsTo(Events::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
