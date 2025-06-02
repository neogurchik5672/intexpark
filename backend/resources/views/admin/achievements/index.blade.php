@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Ачивки</h2>

        <a href="{{ route('admin.achievements.create') }}" class="btn btn-success mb-3">Добавить ачивку</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Интекскоины</th>
                    <th>Картинка</th>
                    <th>Условие</th>
                    <th>Создано</th>
                    <th>Обновлено</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($achievements as $achievement)
                    <tr>
                        <td>{{ $achievement->id }}</td>
                        <td>{{ $achievement->name }}</td>
                        <td>{{ $achievement->description }}</td>
                        <td>{{ $achievement->intexcoin }}</td>
                        <td>
                            @if($achievement->image)
            <img src="{{ asset('storage/' . $achievement->image) }}" alt="Изображение" width="100">
        @else
            <small>Нет изображения</small>
        @endif
    </td>
                        <td>{{ $achievement->required_count }}</td>
                        <td>{{ $achievement->created_at }}</td>
                        <td>{{ $achievement->updated_at }}</td>
                        <td>
                             <a href="{{ route('admin.achievements.edit', $achievement->id) }}" class="btn btn-primary btn-sm">Редактировать</a>
                            <form action="{{ route('admin.achievements.destroy', $achievement->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection