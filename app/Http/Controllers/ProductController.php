<?php
namespace App\Http\Controllers;
use App\Models\History;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\BuyRequest;
use App\Models\User;
use App\Models\Cart;

class ProductController extends Controller
{
  public function index(){
    $query = Product::query()->get();
    $user = User::first();
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
      'count'=>'required|integer|min:0|max:255',      
      'img' => 'image','mimes:jpeg,png,jpg,gif',
 ]);
 $img = isset($request['img']) ? $request['img']->store('products','public') : null; //загрузка изображения
  $events = Product::create([
      'title' => $request['title'],
      'desc' => $request['desc'],
      'img' => $img,
      'price' => $request['price'],
      'count' => $request['count'],
  ]); 
  return redirect()->action([ProductController::class,'index']);
}
        public function destroy($id)
      {
        $product = Product::findOrFail($id); // Получаем пост по ID
        $product->delete();
        return redirect()->action([ProductController::class,'index']);
       }

        public function edit($id)
        {
        $product = Product::findOrFail($id); // Получаем пост по ID
        return view('products.update', compact('product'));
        }

        public function update(Request $request,$id)
        {
          $img = isset($request['img']) ? $request['img']->store('products','public') : null; // добавление картинки в папку
            $validate = $request->validate( [
                'title'=>'required|string|max:255',
                'desc'=>'required|string',
                'price'=>'required|numeric',
                'count'=>'required|integer',              
                'img'=>'image|mimes:jpeg,png,jpg,gif',
           ]);
            $product = Product::where('id',$id)->update(['title' => $validate['title'],'desc' => $validate['desc'],'price' => $validate['price'],'img' => $img,'count' => $validate['count']]);
            return redirect()->action([ProductController::class,'index']);
        }
}