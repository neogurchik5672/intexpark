@extends('layouts.app')
@section('content')
<div class="show">
    <div class="user">
    <h1> {{$query->tg_id}} тг юзернейм</h1>
    <span>{{$query->balance}} коинов</span> 
    </div>

    <div class="myHistory">
        <h1 class="PC" id="PC">История покупок</h1>
       

        <div class="modalMenu" id="modalMenu">
          <div class="flexClose">
          <div class="closeModalMenu" id="closeModalMenu">X</div>
<br>
          <div class="mainModalMenu">
            <p class="titleModalMenu">История покупок</p>
                @foreach ($myHistory as $item)
                <div class="itemHistory">
                    <div class="left">
      <div class="titleHistory">  {{ $item->product->title }} </div>
      </div>
      <div class="right">
          <div class="priceHistory">{{ $item->product->price }}</div>
       <div class="dateHistory">{{preg_replace('/-/','.', preg_replace('/\s.*/',' ', $item->created_at))}}</div>
        </div>
        </div>
        @endforeach
          </div>
          </div>
        </div>
    </div>
@endsection