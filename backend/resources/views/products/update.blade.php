@extends('layouts.app')
@section('content')
<form enctype="multipart/form-data" action="{{route('products.update',$product->id)}}" method="POST">
    @csrf
    @method('PUT') <!-- Метод PUT для обновления ресурса -->
<div> 
    <label for="title">Заголовок</label>
    <input type="text" name="title" id="title" value="{{  $product->title }}" required> <!-- Поле для редактирования заголовка поста -->
</div>

<div>
    <label for="content">описание</label>
    <textarea name="desc" id="desc" rows="5" required>{{ old('description', $product->desc) }}</textarea> <!-- Поле для редактирования содержания поста -->
</div>
<div>
    <input type="number" placeholder="count" name="count" id="count" value="{{  $product->count }}" required> <!-- Поле для ввода содержания поста -->
</div>
<div>
    <label for="content">цена</label>
    <input type="number" name="price" id="content" rows="5" value="{{ $product->price }}" required></input> <!-- Поле для редактирования содержания поста -->
</div>
<div>
    <label for="image">изменить изображение</label>
    <input type="file" name="img" value="{{ $product->img }}" id="images" multiple> <!-- Поле для ввода содержания поста -->
</div>
<button type="submit">Обновить</button> <!-- Кнопка для отправки формы -->
</form>
@endsection