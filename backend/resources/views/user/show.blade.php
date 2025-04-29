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
            <p>{{$item->events->subject}}</p>
            <p>{{$item->events->salary}} коинов</p>
            @if($item->events->type == 'offline')
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
            {{$member->user->tg_id}}<br>
        @endforeach
    </div>  
@endforeach
    </div>
</div>
@endsection