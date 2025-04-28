<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\BuyRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class BuyRequestController extends Controller
{
    public function index(){
        
        $query = BuyRequest::query()->get();
        return view('buyRequests.index', compact('query'));
      }
    public function buy(Product $product){
        $error;
        $query = Product::query()->get();
        $balance = User::first();
        $price = Product::find($product->id);
        if (intval($balance->balance) < intval($price->price)) {
            $error = 'Недостаточно средств на балансе';
            return view('products.index', compact('error','query'));
        }else{
        $buy = BuyRequest::create([
            'user_id' => 1,
            'product_id' => $product->id,
        ]); 
        $balance->balance = intval($balance->balance) - intval($price->price);
        $balance->save();
        $error = 'Товар приобретен';
        return view('products.index', compact('error','query'));
    }
    }
    
}
