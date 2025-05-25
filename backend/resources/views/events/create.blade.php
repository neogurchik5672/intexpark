@extends('layouts.app')
@section('content')
    <div class="items">
    <form enctype="multipart/form-data" action="{{ route('events.store') }}" method="POST">
    @csrf
    <input placeholder="Название" type="text" name="name" id="name" >
    <input placeholder="Кол-человек" type="number" min="1" name="count" id="count" >
    <input placeholder="Адресс/Ссылка" type="text" name="subject" id="subject" >
    <input placeholder="Кол-коинов" type="number" min="1" name="salary" id="salary" >
    <input placeholder="Описание"  type="text" name="desc" id="desc" >


    <select name="type" id="type" onchange="toggleDateTimeFields()">
    <option name="type" id="type" value="Online">Online</option>
    <option name="type" id="type" value="Offline">Offline</option>
</select>
<div style="display: none;" id="dateTimeFields">
    <input placeholder="Дата" type="date" name="data" id="data" >
    <input type="hidden" name="data" id="data">
    <input placeholder="Время" type="time" name="time" id="time" >
    <input type="hidden" name="time" id="time">
</div>
<button  type="submit">Сохранить</button>
</form>
</div>
@endsection