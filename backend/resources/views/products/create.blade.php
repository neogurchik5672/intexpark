@extends('layouts.app')
@section('content')
<div class="createProduct">
<form enctype="multipart/form-data" action="{{ route('product.store') }}" method="POST">
        @csrf <!-- Токен защиты от CSRF -->
        <div>
            <input type="text" placeholder="title" name="title" id="title" > <!-- Поле для ввода заголовка поста -->
        </div> 
        <div>
            <textarea placeholder="description" name="desc" id="content" required></textarea> <!-- Поле для ввода содержания поста -->
        </div>
        <div>
            <input type="number" placeholder="price" name="price" id="price" required> <!-- Поле для ввода содержания поста -->
        </div>
        <div>
    </div>
        <div class="fileCreate">
            <input  id="fileCreate" type="file" name="img" id="images" multiple> <!-- Поле для ввода содержания поста -->
        </div>
        <div>
            <input type="number" placeholder="count" name="count" id="count" min="0" required> <!-- Поле для ввода содержания поста -->
        </div>
        <button type="submit">Сохранить</button> <!-- Кнопка для отправки формы -->
</div>
@endsection