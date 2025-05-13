@extends('layouts.app')
@section('content')
<div class="items">
    @foreach ($query as $item)
    <h1>{{$item->product->title}}</h1>
    <p>{{$item->product->desc}}</p>
    <div class="img"><img src="{{$item->product->img ? asset('storage/'.$item->product->img) : asset('storage/products/default.png') }}" alt="{{$item->product->title}}"></div>  
    <span>{{$item->product->price}} коинов</span>
    <form action="{{route('buyRequest.buy',$item->product->id)}}" method="post">
        @csrf
        <button type="submit">купить</button>
    </form>
    <form action="{{route('cart.destroy',$item->id)}}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit">удалить из корзины</button>
    </form>
    @endforeach
</div>
@endsection