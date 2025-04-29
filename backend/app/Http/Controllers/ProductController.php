<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class ProductController extends Controller
{
  public function index(){
    $query = Product::query()->get();
    $user = User::query()->first();
    return view('products.index', compact('query','user'));
  }
}
