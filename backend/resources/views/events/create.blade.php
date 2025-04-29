@extends('layouts.app')
@section('content')
    <div class="items">
    <form enctype="multipart/form-data" action="{{ route('events.store') }}" method="POST">
    @csrf
    <input placeholder="Название" type="text" name="name" id="name" >
    <input placeholder="Кол-человек" type="text" name="count" id="count" >
    <input placeholder="Адресс/Ссылка" type="text" name="subject" id="subject" >
    <input placeholder="Кол-коинов" type="text" name="salary" id="salary" >
    <input placeholder="Описание"  type="text" name="desc" id="desc" >
    <input placeholder="Дата" type="date" name="data" id="data" >
    <input placeholder="Время" type="time" name="time" id="time" >
    <select name="type" id="type">
    <option name="type" id="type">Online</option>
    <option name="type" id="type">Ofline</option>
</select>
<button  type="submit">Сохранить</button>
</form>
</div>
@endsection