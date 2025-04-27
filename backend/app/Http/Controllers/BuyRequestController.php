<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuyRequest;

class BuyRequestController extends Controller
{
    public function buy(Request $request){
        dd($request);
    }
}
