@extends('layouts.app')
@section('content')
<div class="index">
    <form class="formUser" action="{{route('user.index')}}">
        <input type="search" autofocus placeholder="Поиск" name="search" id="search">
        <ul class="ulUser">          
    @foreach ($query as $item)
            <li class="hide">
                   @<a id="userId" href="{{route('user.all',$item->id)}}"><span>{{$item->tg_id}}</span></a>
            </li>
    @endforeach
        </ul>
    </form>
    @foreach ($query as $item)
        <div class="item">
            @<a id="userId" href="{{route('user.all',$item->id)}}"><span>{{$item->tg_id}}</span></a>
            <p>{{$item->balance}} коинов</p>
            <form enctype="multipart/form-data" action="{{route('user.updateCoins',$item->id)}}" method="POST">
            @csrf
            @method('PUT') <!-- Метод PUT для обновления ресурса -->
            <input type="number" name="coins" min="1" id="coins" placeholder="Зачислить коины">
            <input type="text" name="reason" id="reason" placeholder="Коментарий">
            <button type="submit">Добавить</button> 
</form>
       
                 <div class="form-group">
            <form enctype="multipart/form-data" action="{{route('user.updateCoin',$item->id)}}" method="POST">
            @csrf
            @method('PUT') <!-- Метод PUT для обновления ресурса -->
            <input type="number" name="coins" min="1" id="coins" placeholder="Отнять коины">
            <input type="text" name="reason" id="reason" placeholder="Коментарий">
            <button type="submit">Отнять</button> 
</form>
   </div>
        </div>

@endforeach
</div>
@endsection