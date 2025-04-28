@extends('layouts.app')
@section('content')
<div class="show">
    <h1> {{$query->tg_id}} тг юзернейм</h1>
    <span>{{$query->balance}} коинов</span>
</div>
@endsection