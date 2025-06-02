@extends('layouts.app')
@section('content')

<h1>учет товара</h1>
    <section class="shop">
    @foreach ($query as $item)
        <div class="card">
        <img class="img" src="{{$item->img !== null ? Storage::url($item->img) : asset('storage/products/default.png') }}" alt="{{$item->title}}">  
            <p>{{$item->title}}</p>
          
            <p class="cost">{{$item->price}} коинов</p>
            <form action="{{route('products.edit',$item->id)}}" method="get">
                @csrf
                <button type="submit" class="btn btn_yellow">Изменить</button>
            </form>
            <form action="{{route('products.destroy',$item->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn_yellow">Удалить</button>
            </form>
        </div>
    @endforeach
    </section>
@endsection