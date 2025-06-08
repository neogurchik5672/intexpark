@extends('layouts.app')
@section('checkPageAdaptive','eventsLinkAdaptiveCheck')
@section('checkPage','eventsLink')
@section('content')
<div class="error">
    {{isset($error) ? $error : ''}}
</div>
@foreach ($query as $item)
<div class="item">
    <h1>{{$item->name}}</h1>
    <p>{{$item->desc}}</p>    
    <p>{{$item->type}}</p>
    <p>{{$item->salary}} коинов</p>
    @if($item->type == 'Offline')   
     <p>{{$item->subject}}</p>
    <p>{{$item->data}} {{$item->time}}</p>
    <p>{{count($item->members)}} из {{$item->count}} участников</p>
    @endif
    @if (count($item->members) == $item->count)
        <p>максимально человек</p>        
    @else
    <form action="{{route('member.store',$item->id)}}" method="post">
        @csrf
        <button type="submit">
        @if($item->type == 'Online')
            <a href="{{$item->subject}}">присоедениться</a>
            @elseif ($item->members->where('user_id', $user->id)->isNotEmpty())
                 Вы уже участвуете
            @else
                присоединиться
            @endif
        </button>
    </form>
    @endif
   
</div>
@endforeach
@endsection