@extends('layouts.app')
@section('content')
<div class="admin">
<h1>админка</h1>
    <a href={{route('buyRequest.index')}}>заявки</a><br>
    <a href={{route('user.index')}}>пользователи</a><br>
    <a href={{route('product.create')}}>добавить товар</a><br>
    <a href={{route('events.create')}}>Создать задание</a><br>
    <a href={{route('admin.products')}}>Учёт товара</a>
    </div>
@endsection