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
    $count = Product::find($product->id);
    $count->count = intval($count->count) - 1; // при добавлении в корзину количество отнимается при удалении добавляется
    $count->save();
    return redirect()->action([CartController::class,'index']);
}
public function index(){
    $query = Cart::query()->where('user_id',1)->get();
    return view('cart.index', compact('query'));
  }
         
  public function destroy($id)
      { 

        $product = Cart::findOrFail($id); 
        $product->delete();  
    $count = Product::find($product->product_id);
    $count->count = intval($count->count) - 1;
     $count->save();
        return redirect()->action([CartController::class,'index']);

       }
}
 