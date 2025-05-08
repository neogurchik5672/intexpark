@extends('layouts.app')
@section('content')

<section class="banner">
      <img src="img/banner.png" alt="" />
    </section>

    <section class="text_shop">
      <img src="img/text_shop.png" alt="" />
    </section>

    <section class="shop">
    @foreach ($query as $item)
        <div class="card">
        <img class="img" src="{{$item->img !== 'null' ? Storage::url($item->img) : asset('storage/products/default.png') }}" alt="{{$item->title}}">  
            <p>{{$item->title}}</p>
          
            <p class="cost">{{$item->price}} коинов</p>
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
        </div>
    @endforeach
    </section>
@endsection