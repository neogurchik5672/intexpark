<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }
    public function products(){
        $query = Product::query()->get();
        return view('admin.products',compact('query'));
    }
}
