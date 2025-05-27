@extends('layouts.app')
@section('content')

<section class="banner">
      <img src="img/banner.png" alt="" />
    </section>

    <section class="text_shop">
      <img src="img/text_shop.png" alt="" />
    </section>

    <section class="shop">
        {{-- перебор всех продуктов --}}
    @foreach ($query as $item) 
        <div class="card">
        <img class="img" src="{{$item->img ? Storage::url($item->img) : asset('storage/products/default.png') }}" alt="{{$item->title}}">  
            <p>{{$item->title}}</p>
            
            <p class="cost">{{$item->count}} шт</p>
            <p class="cost">{{$item->price}} коинов</p>

            <form action="{{route('cart.add',$item->id)}}" method="post">
                 @csrf
                {{-- проверки  --}}
                @if (isset($item->cart->user_id) && $item->cart->user_id == $user->id)
                <div class="btn btn_in_basket"><a href="{{route('cart.index')}}">В корзине</a></div>       
                         @elseif ($item->History->where('status', 'buy')->isNotEmpty())
                <div class="btn btn_none">Куплено</div>  
                          
                @elseif($user->balance < $item->price)      
                <div class="btn btn_none">Недостаточно средств</div>
                @elseif ($item->count < 1)
                <div class="btn btn_none">Нет в наличии</div>  
                       
                @else
                <div class="dropdown">
  <div onclick="myFunction()" class="dropbtn">Добавить в корзину</div>
  <div id="myDropdown" class="dropdown-content">
  <p class="test">{{$item->title}}</p>
  <p class="test" class="cost">Описание:{{$item->desc}}</p>
  <p class="test" class="cost">{{$item->price}} коинов</p> 
  <button type="submit" class="btn btn_yellow">Добавить в корзину</button> 
  </div>
</div>
                @endif
                
            </form>
        </div> 
           
     @endforeach
    </section>
@endsection