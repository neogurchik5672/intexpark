@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Создать новую ачивку</h2>

        <form action="{{ route('admin.achievements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Название</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label for="coins" class="form-label">Количество Интекскоинов</label>
                <input type="number" name="intexcoin" id="intexcoin" class="form-control" min="1" required>
            </div>

              <div class="mb-3">
                <label for="image" class="form-label">Изображение</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <div class="mb-3">
                <label for="condition_value" class="form-label">Значение условия</label>
                <input type="number" name="required_count" id="required_count" class="form-control" min="1" required>
            </div>

            <button type="submit" class="btn btn-success">Сохранить</button>
        </form>
    </div>
@endsection
