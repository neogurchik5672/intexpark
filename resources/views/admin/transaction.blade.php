@extends('layouts.app')
@section('content')

    <section class="shop">
    @foreach ($tra as $item)
    <div>
    <p>Транзакция номер:{{$item->id}}</p><br>
<p>Админ:{{$item->admin_id}}</p><br>
<p>Пользователь:{{$item->user_id}}</p><br>
<p>Дата:{{$item->updated_at}}</p><br>
@if ($item->reason == NULL)
<div>Причина: Отсутствует</div>
@else
<p>Причина: {{$item->reason}}</p><br>
@endif

</div>
    @endforeach
    </section>
@endsection