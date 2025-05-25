<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = [
        'title',
        'desc',
        'img',
        'count',
        'price',
        'count',
    ];
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function History()
    {
        return $this->hasMany(History::class);
    }
    public function buyRequest()
    {
        return $this->hasMany(BuyRequest::class);
    }
}
 