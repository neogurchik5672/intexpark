@extends('layouts.app')
@section('checkPageAdaptive','profileLinkAdaptiveCheck')
@section('content')
<div class="bodyUser">
<div class="show">
<div class="userHeader">
    <div class="user">
    <div class="avatar"><div id="addAvatar" class="addAvatar">+</div></div>
    <div class="addAvatarMenu" id="addAvatarMenu">
    <div class="titleAvatarMenu">
        <span>Выберете Аватар</span>
        <div class="closeModalMenuAvatar" id="closeModalMenuAvatar">X</div>
    </div>
    <form id="formAddAvatar" method="POST" action="{{ route('user.addAvatar',$query->id) }}">
          @csrf
        <div class="formUser">
    <input type="radio" id="img1" name="radio" value="Apple.png" />
    <label for="img1"><img src="{{asset('img/avatar/Apple.png')}}" alt="avatar"></label>
    <input type="radio" id="img2" name="radio" value="Bread.png" />
    <label for="img2"><img src="{{asset('img/avatar/Bread.png')}}" alt="avatar"></label>
    <input type="radio" id="img3" name="radio" value="Crown.png" />
    <label for="img3"><img src="{{asset('img/avatar/Crown.png')}}" alt="avatar"></label>
    <input type="radio" id="img4" name="radio" value="Elixir.png" />
    <label for="img4"><img src="{{asset('img/avatar/Elixir.png')}}" alt="avatar"></label>
    <input type="radio" id="img5" name="radio" value="Gem.png" />
    <label for="img5"><img src="{{asset('img/avatar/Gem.png')}}" alt="avatar"></label>
    <input type="radio" id="img6" name="radio" value="Hearth.png" />
    <label for="img6"><img src="{{asset('img/avatar/Hearth.png')}}" alt="avatar"></label>
    <input type="radio" id="img7" name="radio" value="Key.png" />
    <label for="img7"><img src="{{asset('img/avatar/Key.png')}}" alt="avatar"></label>
    <input type="radio" id="img8" name="radio" value="Meat.png" />    
    <label for="img8"><img src="{{asset('img/avatar/Meat.png')}}" alt="avatar"></label>
    <input type="radio" id="img9" name="radio" value="Ring.png" />
    <label for="img9"><img src="{{asset('img/avatar/Ring.png')}}" alt="avatar"></label>
    </div>
    <input type="submit" name="submit" id="submit">
    </form>
    </div>
    <div class="userValue">
    <h1> {{strlen("@".$query->username) > 7 ? strsub($query->username,0,7)."..."}} </h1>
    <span><a href="">ВЫЙТИ</a></span>
    </div>
</div>
<div class="valueInputs">
    <div class="inputsUser"> 10 exp</div>
    <div class="inputsUser"> {{" ".$query->balance}}<img src="{{asset('img/coin.png')}}" alt="icon"></div>
    <div class="inputsUser"> 5 <img src="{{asset('img/vector.png')}}" alt="icon"></div>
</div>

    <div class="myHistory">
       <div class="PC"  id="PC"><h1>ИСТОРИЯ ПОКУПОК</h1></div>
        <div class="modalMenu" id="modalMenu">
          <div class="flexClose">
          <div class="closeModalMenu" id="closeModalMenu">X</div>
          <div class="mainModalMenu">
            <p class="titleModalMenu">История покупок</p>
            <div class="scrollbarUser">
                @foreach ($myHistory as $item)
                <div class="itemHistory">
                    <div class="left">
      <div class="titleHistory">  {{ $item->product->title }} </div>
      </div>
      <div class="right">
          <div class="priceHistory">{{ $item->product->price }}<img src="{{asset('img/coin.png')}}" alt="icon"></div>
       <div class="dateHistory">{{preg_replace('/-/','.', preg_replace('/\s.*/',' ', $item->created_at))}}</div>
        </div>
        </div>
        @endforeach
        </div>
          </div>
          </div>
        </div>
    </div>
</div>

    <!-- перенести на отдельную страницу -->
    <!-- <div class="myEvents">
        <h1>Ближайше события</h1>
        @foreach ($myEvents as $item)
        <div class="item">
            <h1>{{$item->events->name}}</h1>
            <p>{{$item->events->desc}}</p>    
            <p>{{$item->events->type}}</p>
               <p>{{$item->events->salary}} коинов</p>
            @if($item->events->type == 'Offline')  
               <p>{{$item->events->subject}}</p>
            <p>{{$item->events->data}} {{$item->time}}</p>
            <p>{{$item->events->count}} макс. участников</p>
        </div>
        @endif    
    @endforeach
    @foreach ($myOrganizatedEvents as $item)
    ваши события
    <div class="item">
        <h1>{{$item->name}}</h1>
        <p>{{$item->data}} {{$item->time}}</p>
        <p>{{count($item->members)}} из {{$item->count}} участников</p>
        участники: <br>
        @foreach ($item->members as $member)
            {{$member->user->telegram_id}}
            @if(!isset($item->checkevents))
            <form action="{{route('checkEvent.statusOff',$item)}}" method="post">
                @csrf
                <button type="submit">присутствовал</button>
            </form>
            <form action="{{route('checkEvent.statusOffNot',$item)}}" method="post">
                @csrf
                <button type="submit">отсутствовал</button>
            </form>
            @endif
        @endforeach
    </div>  
@endforeach
    </div>
    @foreach ($myBuyRequest as $items)
    <div>
    id заказа:<h1>{{$items->id}}</h1>
    статус:<h1>{{$items->status}}</h1>
    адрес<h1>{{$items->address}}</h1>
</div>
    @endforeach -->
</div>
</div>
@endsection
