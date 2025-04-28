@extends('layouts.app')
@section('content')
    <div class="items">
    <form enctype="multipart/form-data" action="{{ route('events.store') }}" method="POST">
    @csrf
    <input  type="text" name="name" id="name" >
    <input  type="text" name="data" id="data" >
    <input  type="text" name="count" id="count" >
    <input  type="text" name="subject" id="subject" >
    <input  type="text" name="salary" id="salary" >
    <input  type="text" name="desc" id="desc" >
    <input  type="text" name="time" id="time" >
    <select name="type" id="type">
    <option name="type" id="type">Online</option>
    <option name="type" id="type">Ofline</option>
</select>
<button  type="submit">Сохранить</button>
</form>
</div>
@endsection