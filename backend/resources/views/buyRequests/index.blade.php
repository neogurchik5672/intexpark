@extends('layouts.app')
@section('content')
    <div class="items">
    @foreach ($query as $item)
        <div class="item">
            <h1>{{$item->product->title}}</h1>
            <p>{{$item->product->desc}}</p>
            <div class="img"><img src="{{$item->product->img !== 'null' ? Storage::url($item->product->img->first()) : asset('storage/products/default.png') }}" alt="{{$item->product->title}}"></div>  
            <span>{{$item->product->price}} коинов</span>
        </div>
    @endforeach
</div>
@endsection