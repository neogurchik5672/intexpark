<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\BuyRequest;

class BuyRequestController extends Controller
{
    public function index(){
        $query = BuyRequest::query()->get();
        return view('buyRequests.index', compact('query'));
      }
    public function buy(Product $product){
        $buy = BuyRequest::create([
            'user_id' => 1,
            'product_id' => $product->id,
        ]);
        return redirect()->back()->with('success','request is added');
    }
    
}
