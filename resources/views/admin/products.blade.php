@extends('layouts.app')

@section('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Передаём пути к иконкам из Blade в JS -->
    <script>
        const ICON_VISIBLE = "{{ asset('img/admin_card/нав_товар.svg') }}";
        const ICON_HIDDEN = "{{ asset('img/admin_card/обыч_товар.svg') }}";
    </script>

    <script src="{{ asset('js/admin-shop.js') }}"></script>
@endsection

@section('content')
    </section>
    <section class="shop">
        <div class="shop__title-search">
            <h1 class="shop__title">Магазин</h1>
            <input type="text" id="shopSearch" class="shop__search-input" placeholder="ПОИСК">
        </div>
        <button class="shop__add-button" id="openAddModal">
            <img class="shop__add-button-icon" src="{{ asset('img/Union.svg') }}" alt="">
        </button>
        <div class="shop__cards">
            @foreach ($query as $item)
                <div class="shop__card" data-name="{{ $item->title }}">
                    <div class="shop__card-image-container">
                        <img class="shop__card-image"
                            src="{{ $item->img !== null ? Storage::url($item->img) : asset('storage/products/default.png') }}"
                            alt="{{ $item->title }}">
                        <div class="shop__card-actions">
                            <button type="button" 
                                onclick="toggleVisibility({{ $item->id }})" 
                                title="Показывать/Скрывать"
                                id="visibilityButton-{{ $item->id }}">
                                <img class="shop__card-action-icon" 
                                    src="{{ $item->is_visible ? asset('img/admin_card/нав_товар.svg') : asset('img/admin_card/обыч_товар.svg') }}" 
                                    alt="Показывать/Скрывать"
                                    id="visibilityIcon-{{ $item->id }}">    
                                </button>
                            <a href="javascript:void(0)" onclick="openModal('modalEdit-{{ $item->id }}')"
                                title="Редактировать">
                                <img class="shop__card-action-icon" src="{{ asset('img/admin_card/edit-2.svg') }}"
                                    alt="Редактировать">
                            </a>
                            <button type="button" onclick="openDeleteModal({{ $item->id }}, '{{ $item->title }}')"
                                title="Удалить">
                                <img class="shop__card-action-icon" src="{{ asset('img/admin_card/trash.svg') }}"
                                    alt="Удалить">
                            </button>
                        </div>
                    </div>
                    <div class="shop__card-title-wrapper">
                        <h3 class="shop__card-title">{{ $item->title }}</h3>
                    </div>
                    <a href="javascript:void(0)" onclick="openModal('modalDetails-{{ $item->id }}')"
                        class="shop__card-button shop__card-button--yellow">Подробнее</a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Модалка подтверждения удаления -->
    <div id="modalDeleteConfirm" class="modal" style="display:none;">
        <div class="modal__content">
            <div class="modal__body">
                <p id="deleteConfirmText">Вы уверены, что хотите удалить этот товар?</p>
            </div>
            <div class="modal__footer">
                <button type="button" class="modal__button modal__button--cancel"
                    onclick="closeModal('modalDeleteConfirm')">Отмена</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modal__button modal__button--delete">Удалить</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Модалка подтверждения сохранения -->
    <div id="modalSaveConfirm" class="modal" style="display:none;">
        <div class="modal__content">
            <div class="modal__body">
                <p id="saveConfirmText">Вы уверены, что хотите сохранить изменения?</p>
            </div>
            <div class="modal__footer">
                <button type="button" class="modal__button modal__button--cancel"
                    onclick="closeModal('modalSaveConfirm')">Отмена</button>
                <button type="button" id="confirmSaveBtn" class="modal__button modal__button--save">Сохранить</button>
            </div>
        </div>
    </div>

    <!-- Модалка создания товара -->
    <div id="modalCreate" class="modal" style="display:none;">
        <div class="modal__content">
            <h2 class="modal__title">Добавление товара</h2>
            <form id="createForm" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal__body">
                    <div class="modal__left">
                        <div class="modal__image-wrapper">
                            <label class="modal__image-placeholder" id="createImagePlaceholder">
                                <input type="file" name="img" id="createImageInput" class="modal__file-input"
                                    accept="image/*">
                                <span class="modal__plus">+</span>
                            </label>
                            <img class="modal__image-preview" id="createImagePreview" src="" alt="Превью"
                                style="display: none;">
                        </div>
                    </div>
                    <div class="modal__right">
                        <label class="modal__label">Наименование</label>
                        <input type="text" name="title" required class="modal__input">

                        <label class="modal__label">Описание</label>
                        <textarea name="desc" required class="modal__textarea"></textarea>

                        <div class="modal__price-count">
                            <div>
                                <label class="modal__label">Цена</label>
                                <input type="number" name="price" required class="modal__input">
                            </div>
                            <div>
                                <label class="modal__label">Количество</label>
                                <input type="number" name="count" required class="modal__input">
                            </div>
                            <div class="modal__checkbox-wrapper">
                                <label class="modal__checkbox-label">Мерч</label>
                                <label class="modal__checkbox-control">
                                    <input type="checkbox" name="is_merch" value="1" class="modal__checkbox">
                                    <span class="modal__checkbox-box"></span>
                                </label>
                            </div>
                            <div class="modal__checkbox-wrapper">
                                <label class="modal__checkbox-label">Разовая покупка</label>
                                <label class="modal__checkbox-control">
                                    <input type="checkbox" name="is_one_time_purchase" value="1" class="modal__checkbox">
                                    <span class="modal__checkbox-box"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal__footer">
                    <button type="button" class="modal__button modal__button--cancel"
                        onclick="closeModal('modalCreate')">Отмена</button>
                    <button type="button" class="modal__button modal__button--save"
                        onclick="confirmSave('createForm', 'Вы уверены, что хотите добавить новый товар?')">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Модалка редактирования товаров -->
    @foreach ($query as $item)
        <div id="modalEdit-{{ $item->id }}" class="modal" style="display:none;">
            <div class="modal__content">
                <h2 class="modal__title">Редактирование товара</h2>
                <form id="editForm-{{ $item->id }}" action="{{ route('products.update', $item->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if ($item->img)
                        <input type="hidden" name="current_img" value="{{ $item->img }}">
                    @endif
                    <div class="modal__body">
                        <div class="modal__left">
                            <div class="modal__image-wrapper">
                                @if ($item->img)
                                    <div class="modal__image-overlay">
                                        <label class="modal__image-label">
                                            <input type="file" name="img" class="modal__file-input"
                                                accept="image/*">
                                            <span class="modal__plus">+</span>
                                        </label>
                                        <img class="modal__image-preview" src="{{ Storage::url($item->img) }}"
                                            data-original-src="{{ Storage::url($item->img) }}" alt="Изображение">
                                    </div>
                                @else
                                    <label class="modal__image-placeholder">
                                        <input type="file" name="img" class="modal__file-input" accept="image/*">
                                        <span class="modal__plus">+</span>
                                    </label>
                                    <!-- Добавлено: скрытое изображение для предпросмотра -->
                                    <img class="modal__image-preview" src="" alt="Превью"
                                        style="display:none;">
                                @endif
                            </div>
                        </div>

                        <div class="modal__right">
                            <label class="modal__label">Наименование</label>
                            <input type="text" name="title" value="{{ $item->title }}" required
                                class="modal__input">

                            <label class="modal__label">Описание</label>
                            <textarea name="desc" required class="modal__textarea">{{ $item->desc }}</textarea>

                            <div class="modal__price-count">
                                <div>
                                    <label class="modal__label">Цена</label>
                                    <input type="number" name="price" value="{{ $item->price }}" required
                                        class="modal__input">
                                </div>
                                <div>
                                    <label class="modal__label">Количество</label>
                                    <input type="number" name="count" value="{{ $item->count }}" required
                                        class="modal__input">
                                </div>
                                <div class="modal__checkbox-wrapper">
                                    <label class="modal__checkbox-label">Мерч</label>
                                    <label class="modal__checkbox-control">
                                        <input type="checkbox" name="is_merch" value="1"
                                            {{ $item->is_merch ? 'checked' : '' }} class="modal__checkbox">
                                        <span class="modal__checkbox-box"></span>
                                    </label>
                                </div>
                                <div class="modal__checkbox-wrapper">
                                    <label class="modal__checkbox-label">Разовая покупка</label>
                                    <label class="modal__checkbox-control">
                                        <input type="checkbox" name="is_one_time_purchase" value="1" 
                                            {{ $item->is_one_time_purchase ? 'checked' : '' }} class="modal__checkbox">
                                        <span class="modal__checkbox-box"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal__footer">
                        <button type="button" onclick="closeModal('modalEdit-{{ $item->id }}')"
                            class="modal__button modal__button--cancel">Выйти</button>
                        <button type="button" class="modal__button modal__button--save"
                            onclick="confirmSave('editForm-{{ $item->id }}', 'Вы уверены, что хотите сохранить изменения?')">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <!-- Модалка подрообнее -->
    @foreach ($query as $item)
        <div id="modalDetails-{{ $item->id }}" class="modal" style="display:none;">
            <div class="modal__backdrop">
                <div class="modalka modal__content">
                    <div class="modalka__info">
                        <div class="modalka__image-wrapper">
                            <img class="modalka__image"
                                src="{{ $item->img !== null ? Storage::url($item->img) : asset('storage/products/default.png') }}"
                                alt="{{ $item->title }}" />
                        </div>

                        <div class="modalka__product-info">
                            <div class="modalka__product-text">
                                <p class="modalka__product-name">{{ $item->title }}</p>
                                <p class="modalka__description">{{ $item->desc }}</p>
                            </div>

                            <div class="modalka__price">
                                <p>{{ $item->price }}</p>
                                <img src="{{ asset('img/коин.svg') }}" alt="" class="intexcoin">
                                <p>Мерч: <strong>{{ $item->is_merch ? 'Да' : 'Нет' }}</strong></p>
                                <p>Разовая покупка: <strong>{{ $item->is_one_time_purchase ? 'Да' : 'Нет' }}</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="modalka__footer">
                        <button type="button" onclick="closeModal('modalDetails-{{ $item->id }}')"
                            class="modalka__button modal__button--cancel">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </section>
@endsection

@section('styles')
    <link href="{{ asset('css/admin-shop.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('js/admin-shop.js') }}"></script>
@endsection
