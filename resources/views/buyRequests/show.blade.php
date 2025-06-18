@extends('layouts.app')
@section('content')
    <div class="items">
    <form enctype="multipart/form-data" action="{{ route('buyRequest.create',$show->id) }}" method="POST">
    @csrf
<button  type="submit">Сохранить</button>
</form>
</div>
@endsection