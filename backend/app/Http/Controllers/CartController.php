<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function add(Product $product){
        $cartItem = Cart::updateOrCreate(
        ['user_id'=>1,'product_id' => $product->id],
        []
    );
    return redirect()->action([ProductController::class,'index']);
}
public function index(){
    $query = Cart::query()->where('user_id',1)->get();
    return view('cart.index', compact('query'));
  }
}
