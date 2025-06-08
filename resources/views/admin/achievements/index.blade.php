@extends('layouts.app')

@section('content')

<!-- уведомление изменения достижения -->
<!-- @if(session('success'))
    <div id="notification" class="centered-notification success">
        {{ session('success') }}
    </div>
@endif -->

<div class="achievements-container">
<div class="header-section">
    <div class="achievements-title">Достижения</div>
    <div class="search-bar">
        <input type="text" id="achievementSearch" class="achievement__search-input" placeholder="Поиск" />
    </div>
</div>

<button class="button__add">
    <img src="{{ asset('img/Union.svg')}}" alt="">
</button>
<div class="modal" id="achievementModal">
    <div class="modal-content">
        <!-- <span class="close-btn" id="closeModalBtn">&times;</span> -->
        <h2>Добавление достижения</h2>
        <form action="{{ route('admin.achievements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-form-container">
                <!-- Левая часть с загрузкой изображения -->
                <div class="modal-image-section">
                    <div class="image-upload-container">
                        <label for="image" class="image-upload-label">
                            <div class="image-preview" id="imagePreview">
                                <span class="plus-icon">+</span>
                            </div>
                            <input type="file" name="image" id="image" class="image-upload-input" accept="image/*">
                        </label>
                    </div>
                </div>
                
                <!-- Правая часть с полями ввода -->
                <div class="modal-fields-section">
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
                        <label for="condition_value" class="form-label">Значение условия</label>
                        <input type="number" name="required_count" id="required_count" class="form-control" min="1" required>
                    </div>
                </div>
            </div>

            <div class="shop-modal__footer">
                <button type="button" class="achievement-btn achievement-btn__cancel" onclick="closeModal('achievementModal')">Выйти</button>
                <button type="submit" class="achievement-btn achievement-btn__save">Добавить</button>
            </div>
        </form>
    </div>
</div>
<!-- Модальное окно редактирования достижения -->
<div class="modal" id="editAchievementModal">
    <div class="modal-content">
        <!-- <span class="close-btn" id="closeEditModalBtn">&times;</span> -->
        <h2>Редактирование достижения</h2>
        <form id="editAchievementForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-form-container">
                <!-- Левая часть с загрузкой изображения -->
                <div class="modal-image-section">
                    <div class="image-upload-container">
                        <label for="edit_image" class="image-upload-label">
                            <div class="image-preview" id="editImagePreview">
                                <span class="plus-icon">+</span>
                            </div>
                            <input type="file" name="image" id="edit_image" class="image-upload-input" accept="image/*">
                        </label>
                    </div>
                </div>
                <!-- Правая часть с полями ввода -->
                <div class="modal-fields-section">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Название</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Описание</label>
                        <textarea name="description" id="edit_description" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_intexcoin" class="form-label">Количество Интекскоинов</label>
                        <input type="number" name="intexcoin" id="edit_intexcoin" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_required_count" class="form-label">Значение условия</label>
                        <input type="number" name="required_count" id="edit_required_count" class="form-control" min="1" required>
                    </div>
                </div>
            </div>
            <div class="shop-modal__footer">
                <button type="button" class="achievement-btn achievement-btn__cancel" onclick="closeModal('editAchievementModal')">Выйти</button>
                <button type="submit" class="achievement-btn achievement-btn__save">Сохранить</button>
            </div>
        </form>
    </div>
</div>
<!-- Модальное окно подтверждения удаления -->
<div class="modal" id="deleteConfirmModal">
    <div class="modal-content small-modal">
        <!-- <span class="close-btn" id="closeDeleteModalBtn">&times;</span> -->
        <h2 style="text-align: center; font-family: Montserrat-Bold;">Удалить достижение</h2>
        <p id="achievementNameToDelete" style="text-align: center; font-size: 20px; margin-bottom: 30px;"></p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div style="display: flex; justify-content: center;">
                <button type="submit" class="achievement-btn achievement-btn__delete">Удалить</button>
            </div>
        </form>
    </div>
</div>

    <div class="achievements-scroll-wrapper">
        <div class="achievements-grid">
           @foreach($achievements as $achievement)
<div class="achievement-card" data-name="{{ $achievement->name }}" data-required-count="{{ $achievement->required_count }}">
    
    <!-- Кнопки действия -->
    <div class="card-actions">
        <!-- Редактировать -->
        <a href="{{ route('admin.achievements.edit', $achievement->id) }}" class="btn-edit" data-id="{{ $achievement->id }}">
            <img src="{{ asset('img/edit.svg') }}" alt="Редактировать" class="icon-default">
             <img src="{{ asset('img/edit_filled.svg') }}" alt="Редактировать" class="icon-hover" >
        </a>

        <!-- Удалить -->
   <button type="button" class="btn-delete open-delete-modal" data-id="{{ $achievement->id }}" data-name="{{ $achievement->name }}">
    <img src="{{ asset('img/delete.svg') }}" alt="Удалить" class="icon-default">
       <img src="{{ asset('img/delete_filled.svg') }}" alt="Удалить" class="icon-hover" >
</button>
    </div>

    <div class="achievement-item">
        <div class="achievement-icon">
            <img src="{{ asset('storage/' . $achievement->image) }}"
                alt="{{ $achievement->name }}"
                class="achievement-img"
                onerror="this.src='{{ asset('img/Coin.png') }}'; this.onerror=null;">
        </div>
        <div class="achievement-info">
            <h3>{{ $achievement->name }}</h3>
            <p>{{ $achievement->description }}</p>
        </div>
    </div>
    <!-- Блок с монеткой и количеством -->
    <div class="achievement-coins">
        <img src="{{ asset('img/коин.svg') }}" class="coin-icon">
        <span class="coins">+{{ $achievement->intexcoin }}</span>
    </div>
</div>
@endforeach
        </div>
    </div>
    
</div>
@endsection

@section('styles')
<link href="{{ asset('/css/AdminAchievements.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ asset('/js/AdminAchievements.js') }}"></script>
@endsection