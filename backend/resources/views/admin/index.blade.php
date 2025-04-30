@extends('layouts.app')
@section('content')
    <ul>
        <li><a href={{route('buyRequest.index')}}>заявки</a></li>
        <li><a href={{route('user.index')}}>пользователи</a></li>
        <li><a href={{route('product.create')}}>добавить товар</a></li>
        <li><a href={{route('events.create')}}>Создать задание</a></li>
    </ul>
@endsection