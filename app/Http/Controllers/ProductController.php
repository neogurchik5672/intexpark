<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\BuyRequest;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  public function index()
  {
    $query = Product::query()->get();
    $user = User::first();
    return view('products.index', compact('query', 'user'));
  }

  public function create()
  {
    return view('products.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'title' => 'required|string|max:40',
      'desc' => 'required|string|max:255',
      'price' => 'required|integer|max:255000',
      'count' => 'required|integer|min:0|max:255',
      'img' => 'image',
      'mimes:jpeg,png,jpg,gif|max:10240',
      'is_merch' => 'nullable|boolean',
    ]);
    $img = isset($request['img']) ? $request['img']->store('products', 'public') : null; //загрузка изображения
    $events = Product::create([
      'title' => $request['title'],
      'desc' => $request['desc'],
      'img' => $img,
      'price' => $request['price'],
      'count' => $request['count'],
      'is_merch' => $request->has('is_merch') ? true : false,
    ]);
    // return redirect()->action([ProductController::class,'index']);
    return back()->with('success', 'Товар успешно создан');
  }
  public function destroy($id)
  {
    $product = Product::findOrFail($id); // Получаем пост по ID
    $product->delete();

    return back()->with('success', 'Товар успешно удален');
    // return redirect()->action([ProductController::class,'index']);
  }

  public function edit($id)
  {
    $product = Product::findOrFail($id); // Получаем пост по ID
    return view('products.update', compact('product'));
  }

  public function update(Request $request, $id)
  {
    $product = Product::findOrFail($id);

    $validate = $request->validate([
      'title' => 'required|string|max:40',
      'desc' => 'required|string|max:255',
      'price' => 'required|numeric',
      'count' => 'required|integer',
      'img' => 'nullable|image|mimes:jpeg,png,jpg,gif',
      'is_merch' => 'nullable|boolean',
    ]);

    $data = [
      'title' => $validate['title'],
      'desc' => $validate['desc'],
      'price' => $validate['price'],
      'count' => $validate['count'],
      'is_merch' => $request->has('is_merch') ? true : false,
    ];

    // Обработка изображения
    if ($request->hasFile('img')) {
      // Удаляем старое изображение, если оно есть
      if ($product->img) {
        Storage::disk('public')->delete($product->img);
      }
      // Сохраняем новое изображение
      $data['img'] = $request->file('img')->store('products', 'public');
    } else {
      // Сохраняем текущее изображение
      $data['img'] = $product->img;
    }

    $product->update($data);

    return back()->with('success', 'Товар успешно обновлен');
  }
  
  
}
