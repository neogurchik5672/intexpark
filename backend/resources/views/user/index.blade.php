@extends('layouts.app')
@section('content')
<div class="index">
    @foreach ($query as $item)
        <div class="item">
            <a href="{{route('user.all',$item->id)}}">{{$item->tg_id}} тг юзернейм</a>
            <span>{{$item->balance}} коинов</span>
            <form enctype="multipart/form-data" action="{{route('user.updateCoins',$item->id)}}" method="POST">
            @csrf
            @method('PUT') <!-- Метод PUT для обновления ресурса -->
            <input type="number" name="coins" min="1" id="coins" placeholder="Зачислить коины">
            <button type="submit">Добавить</button> 
        </div>
@endforeach
</div>
@endsection