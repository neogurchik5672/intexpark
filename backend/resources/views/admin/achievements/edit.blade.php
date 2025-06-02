@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Редактировать ачивку</h2>

        <form action="{{ route('admin.achievements.update', $achievement->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Название</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $achievement->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $achievement->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Изображение</label>
                <input type="file" name="image" id="image" class="form-control">
                @if ($achievement->image)
                    <img src="{{ asset('storage/' . $achievement->image) }}" width="100" class="mt-2">
                @endif
            </div>

            <div class="mb-3">
                <label for="coins" class="form-label">Количество коинов</label>
                <input type="number" name="intexcoin" id="intexcoin" class="form-control" value="{{ old('intexcoin', $achievement->intexcoin) }}" min="1" required>
            </div>

            <div class="mb-3">
                <label for="condition_type" class="form-label">Тип условия</label>
                <input type="text" name="required_count" id="required_count" class="form-control" value="{{ old('required_count', $achievement->required_count) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Обновить</button>
        </form>
    </div>
