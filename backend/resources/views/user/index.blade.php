@extends('layouts.app')
@section('content')
<div class="index">
    @foreach ($query as $item)
        <div class="item">
            <h1>{{$item->tg_id}} тг юзернейм</h1>
            <span>{{$item->balance}} коинов</span>
        </div>

</div>
@endsection