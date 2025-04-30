@extends('layouts.app')
@section('content')
<div class="show">
    <div class="user">
    <h1> {{$query->tg_id}} тг юзернейм</h1>
    <span>{{$query->balance}} коинов</span> 
    </div>
    <div class="myEvents">
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
            {{$member->user->tg_id}}
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
    @endforeach
</div>
@endsection