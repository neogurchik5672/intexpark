@extends('layouts.app')
@section('content')
<div class="error">
    {{isset($error) ? $error : ''}}
</div>
<div class="user">
</div>
    <div class="items">
    @foreach ($query as $item)
        <div class="item">
            <h1>{{$item->title}}</h1>
            <p>{{$item->desc}}</p>
            <p>{{$item->count}}</p>
            <div class="img"><img src="{{$item->img !== 'null' ? Storage::url($item->img) : asset('storage/products/default.png') }}" alt="{{$item->title}}"></div>  
            <span>{{$item->price}} коинов</span>
            <form action="{{route('buyRequest.buy',$item->id)}}" method="post">
                @csrf
                
                @if($user->balance < $item->price)

                
                <div>Недостаточно средств</div>
                @else
                @if ($item->count >0)
                
                <button type="submit">Купить</button>

               
              
                @else
                <div>Нет в наличии</div>
             
  @endif
            @endif       
            </form>


            <form action="{{route('products.edit',$item->id)}}" method="get">
                @csrf
                <button type="submit">изменить</button>
            </form>
            <form action="{{route('products.destroy',$item->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit">удалить</button>
            </form>
        </div>
    @endforeach
</div>
@endsection