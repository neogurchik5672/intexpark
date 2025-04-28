@extends('layouts.app')
@section('content')
@foreach ($query as $item)
<div class="item">
    <h1>{{$item->name}}</h1>
    <p>{{$item->desc}}</p>    
    <p>{{$item->type}}</p>
    <p>{{$item->subject}}</p>
    <p>{{$item->salary}} коинов</p>
    @if($item->type == 'offline')
    <p>{{$item->data}} {{$item->time}}</p>
    <p>{{$item->count}} макс. участников</p>
    <form action="{{route('member.store',$item->id)}}" method="post">
        @csrf
        <button type="submit">присоедениться</button>
    </form>
    @endif    
</div>
@endforeach
@endsection