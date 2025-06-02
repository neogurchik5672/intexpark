@extends('layouts.app')
@section('content')

    <section class="shop">
    @foreach ($tra as $item)
    <div>
    <p>Транзакция номер:{{$item->id}}</p><br>
<p>Админ:{{$item->admin_id}}</p><br>
<p>Пользователь:{{$item->user_id}}</p><br>
<p>Дата:{{$item->updated_at}}</p><br>
<p>Причина:{{$item->reason}}</p><br>
</div>
    @endforeach
    </section>
@endsection