<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
  public function index(){
    $query = Product::query()->get();
    return view('products.index', compact('query'));
  }
}
