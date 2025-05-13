@extends('layouts.app')
@section('content')
    <section class="shop">
    @foreach ($query as $item)
      <div class="card">
            <div class="img"><img class="card_img" src="{{$item->img ? Storage::url($item->img) : asset('storage/products/default.png') }}" alt="{{$item->title}}"></div>  
            <p>{{$item->title}}</p>
            <p class="cost">{{$item->price}} коинов</p>
            <div class="dropdown-container">
                @foreach ($buy as $buyItem)
                @if ($buyItem->product_id == $item->id)
                <button type="button" class="btn btn_yellow dropdown-btn">
              <div>заявки</div> 
            <div><img src="{{asset('storage/products/arroy_bottom.png')}}" alt=""/></div>
          </button>
          <div class="dropdown-content">
          <a href="{{ route('buyRequest.show',$buyItem->id) }}">
          {{ $buyItem->user->tg_id}}  
        </a>
          </div>
          @else
          <button type="submit" class="btn btn_none">нет заявок</button>
                @endif
                @endforeach
        </div>
        </div>
    @endforeach
    </section>
@endsection