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
        $balance = DB::table('users')->first('balance');
        $price = DB::table('products')->first('price');
        if ($balance < $price) {

            $error = 'Недостаточно средств на балансе';

        }else{
        $buy = BuyRequest::create([
            'user_id' => 1,
            'product_id' => $product->id,
        ]); 
        $balance = number_format($balance) - number_format($price);
        $balance->save();
         dd($balance);
    }
   
        return redirect()->back()->with('success','request is added');
    }
    
}
