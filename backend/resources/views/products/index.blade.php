@extends('layouts.app')
@section('content')
<div class="error">
    {{isset($error) ? $error : ''}}
</div>
<div class="user">
    {{$user->tg_id}} <br>
    {{$user->balance}} коинов
</div>
    <div class="items">
    @foreach ($query as $item)
        <div class="item">
            <h1>{{$item->title}}</h1>
            <p>{{$item->desc}}</p>
            <div class="img"><img src="{{$item->img !== 'null' ? Storage::url($item->img) : asset('storage/products/default.png') }}" alt="{{$item->title}}"></div>  
            <span>{{$item->price}} коинов</span>
            <form action="{{route('buyRequest.buy',$item->id)}}" method="post">
                @csrf
                <button type="submit">Купить</button>
            </form>
        </div>
    @endforeach
</div>
@endsection