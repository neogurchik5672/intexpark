@extends('layouts.app')
@section('content')
<div class="error">
    {{isset($error) ? $error : ''}}
</div>
@foreach ($query as $item)
<div class="item">
    <h1>{{$item->name}}</h1>
    <p>{{$item->desc}}</p>    
    <p>{{$item->type}}</p>
    <p>{{$item->subject}}</p>
    <p>{{$item->salary}} коинов</p>
    @if($item->type == 'Ofline')
    <p>{{$item->data}} {{$item->time}}</p>
    <p>{{count($item->members)}} из {{$item->count}} участников</p>
    @if (count($item->members) == $item->count)
        <p>максимально человек</p>        
    @else
    <form action="{{route('member.store',$item->id)}}" method="post">
        @csrf
        <button type="submit">присоедениться</button>
    </form>
    @endif
    @endif    
</div>
@endforeach
@endsection