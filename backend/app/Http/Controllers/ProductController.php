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
  public function create(){
    return view('products.create');
  }
  public function store(Request $request){
    $request->validate( [
      'title'=>'required|string|max:255',
      'desc'=>'required|string|max:255',
      'price'=>'required|integer|max:255',      
      'img' => 'image','mimes:jpeg,png,jpg,gif',
 ]);
 $img = isset($request['img']) ? $request['img']->store('products','public') : 'null';
  $events = Product::create([
      'title' => $request['title'],
      'desc' => $request['desc'],
      'img' => $img,
      'price' => $request['price'],
  ]); 
  return redirect()->action([ProductController::class,'index']);
}
}