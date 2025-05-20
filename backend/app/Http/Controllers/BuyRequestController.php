<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\BuyRequest;
use App\Models\User;
use App\Models\History;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
class BuyRequestController extends Controller
{
    public function index(Product $product){
        $query = Product::query()->get();
        $buy = BuyRequest::query()->get();
        return view('buyRequests.index', compact('query','buy'));
      }
    public function buy(Product $product){ //при покупке изменяется баланс,продукт записывается в историю и добавляется в лист ожидания
        $query = Product::query()->get();
        $balance = User::query()->first();
        $price = Product::find($product->id);
        $cart = Cart::query()->where('product_id',$product->id);
        $cart->delete();
        $buy = BuyRequest::create([
            'user_id' => 1,
            'product_id' => $product->id,
        ]); 
                $history = History::create([
            'user_id' => 1,
            'product_id' => $product->id,
        ]); 
        $balance->balance = intval($balance->balance) - intval($price->price);
        $balance->save();
        $error = 'Товар приобретен';
        return redirect()->action([ProductController::class,'index']);
    }
    
    public function show($id){
        $show = BuyRequest::findOrFail($id);
        return view('buyRequests.show', compact('show'));
      }
      public function create(Request $request,$id){
        $validated = $request->validate([
            'address' => 'required|string',
            'status' => 'required|string'
        ]);
        $buyRequest = BuyRequest::findOrFail($id);
    $buyRequest->update($validated);
    return redirect()->action([ProductController::class,'index']);
      }
}
