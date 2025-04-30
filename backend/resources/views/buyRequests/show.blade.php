@extends('layouts.app')
@section('content')
    <div class="items">
    <form enctype="multipart/form-data" action="{{ route('buyRequest.create',$show->id) }}" method="POST">
    @csrf
    <select name="status" id="status">
    <option name="status" id="status">Ожидает рассмотрения</option>
    <option name="status" id="status">Принят на сборку</option>
    <option name="status" id="status">Готов к выдаче</option>
</select>
<select name="address" id="address">
    <option name="address" id="address">г. Омск, ул. Красный Путь, 103</option>
    <option name="address" id="address">г. Омск, пр. Комарова, 21к1</option>
</select>
<button  type="submit">Сохранить</button>
</form>
</div>
@endsection