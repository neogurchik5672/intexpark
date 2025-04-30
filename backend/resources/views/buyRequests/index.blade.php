@extends('layouts.app')
@section('content')
    <div class="items">
    @foreach ($query as $item)
        <div class="item">

            <a href="{{ route('buyRequest.show', $item->id) }}">{{$item->product->title}}</a>
            <p>{{$item->id}}</p>
            <p>{{$item->product->desc}}</p>
            <div class="img"><img src="{{$item->product->img !== 'null' ? Storage::url($item->product->img) : asset('storage/products/default.png') }}" alt="{{$item->product->title}}"></div>  
            <span>{{$item->product->price}} коинов</span>
        </div>
    @endforeach
</div>
@endsection