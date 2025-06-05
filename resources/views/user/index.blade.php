@extends('layouts.app')
@section('content')
<div class="index">
    <form class="formUser" action="{{route('user.index')}}">
        <input type="search" autofocus placeholder="Поиск" name="search" id="search">

        <ul class="ulUser">   
        <div class="scrollAllUsersUl">
    @foreach ($query as $item)
            <li class="hide">
                   <a id="userId" href="{{route('user.all',$item->id)}}"><span>{{"@".$item->telegram_id}}</span></a>
            </li>
    @endforeach
        </div>
        </ul>
    </form>

    менять картинку при наведении 
 <img data-onclick="4" onmouseout="this.src='{{asset('img/coin.png')}}'" onmouseover="this.src='{{asset('img/profile.png')}}'" src="{{asset('img/profile.png')}}">
    @foreach ($query as $item)
        <div class="item">
            @<a id="userId" href="{{route('user.all',$item->id)}}"><span>{{$item->telegram_id}}</span></a>
            <p>{{$item->balance}} коинов</p>
            <form enctype="multipart/form-data" action="{{route('user.updateCoins',$item->id)}}" method="POST">
            @csrf
            @method('PUT') <!-- Метод PUT для обновления ресурса -->
            <input type="number" name="balance" min="1" id="balance" value="{{$item->balance}}">
            <input type="text" name="reason" id="reason" placeholder="Коментарий">
            <button type="submit">Добавить</button> 

@if ($item->role != 'admin')
                 <div class="form-group">
            <form enctype="multipart/form-data" action="{{route('admin.newAdmin',$item->id)}}" method="POST">
            @csrf
            @method('PUT') <!-- Метод PUT для обновления ресурса -->
            <button type="submit">Назначить админом</button> 
</form>
   </div>
@endif
   </div>

        </div>

@endforeach
</div>
@endsection