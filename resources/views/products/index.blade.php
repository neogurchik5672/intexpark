<!-- подключение из resourses/views/layouts/app.blade.php -->
@extends('layouts.app')

@section('content')

<!-- всетречающая надпись добро подаловать... с анимацицей -->
<div class="banner">
    <img src="img/banner_icons/Sword.png" alt="" class="banner__image--sword">
    <img src="img/banner_icons/Chest.png" alt="" class="banner__image--chest">

    <img src="img/banner_icons/Backpack.png" alt="" class="banner__image--backpack">
    <img src="img/banner_icons/Map.png" alt="" class="banner__image--map">

    <p class="banner__descriptor">добро пожаловать в</p>
    <p class="banner__title">интекспарк</p>

    <img src="img/banner_icons/Book.png" alt="" class="banner__image--book">
    <img src="img/banner_icons/Compass.png" alt="" class="banner__image--compass">
</div>

<!-- надпись МАГАЗИН с анимацией бликов -->
<div class="shop-banner">
    <div class="shop-title">
        <span>магазин</span>
        <div class="glow-rect" id="rect1"></div>
        <div class="glow-rect" id="rect2"></div>
    </div>
</div>

<!-- карточки магазина -->
<section class="shop">
    <div class="shop__cards">
        @foreach ($query as $item)
        <div class="shop__card" data-name="{{ $item->title }}">
            <div class="shop__card-image-container">
                <img class="shop__card-image"
                    src="{{ $item->img !== null ? Storage::url($item->img) : asset('storage/products/default.png') }}"
                    alt="{{ $item->title }}">
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

<!-- модальное окно при нажатии подробнее -->
@foreach ($query as $item)
<div id="modalDetails-{{ $item->id }}" class="modal" style="display:none;">
    <div class="modal__backdrop" onclick="closeModal('modalDetails-{{ $item->id }}')"></div>
    <div class="modalka">
        <div class="modalka__info">
            <div class="modalka__image-wrapper">
                <img class="madalka__image"
                    src="{{$item->img !== null ? Storage::url($item->img) : asset('storage/products/default.png') }}"
                    alt="{{$item->title}}" />
            </div>

            <div class="modalka__product-info">
                <div class="modalka__product-text">
                    <p class="modalka__product-name">{{$item->title}}</p>
                    <p class="modalka__description">{{$item->desc}}</p>
                </div>

                <div class="modalka__price">
                    <p>{{$item->price}}</p>
                    <img src="{{ asset('img/коин.svg') }}" alt="" class="intexcoin">
                </div>
            </div>
        </div>

        @if (isset($item->cart->user_id) && $item->cart->user_id == $user->id)
        <div class="modalka__button modalka__button--purchased" data-message="ПОЗДРАВЛЯЕМ, ТОВАР ОПЛАЧЕН! С тебя было списано {{ $item->price }} интекскоинов">
            КУПЛЕНО
        </div>
        @elseif ($item->History->where('status', 'buy')->isNotEmpty())
        <div class="modalka__button modalka__button--purchased" data-message="ПОЗДРАВЛЯЕМ, ТОВАР ОПЛАЧЕН! С тебя было списано {{ $item->price }} интекскоинов">
            КУПЛЕНО
        </div>
        @elseif($user->balance < $item->price)
            <div class="modalka__button modalka__button--disabled" data-message="НЕДОСТАТОЧНО ИНТЕКСКОИНОВ. Невозможно оплатить товар">
                НЕДОСТУПНО
            </div>
            @elseif ($item->count < 1)
                <div class="modalka__button modalka__button--disabled" data-message="Товар временно отсутствует на складе">
                НЕТ В НАЛИЧИИ
    </div>
    @else
    <button class="modalka__button modalka__button--buy" onclick="buyProduct({{ $item->id }}, {{ $item->price }})">
        КУПИТЬ
    </button>
    @endif
</div>
</div>
@endforeach

@endsection

<!-- подключение css -->
@section('indexstyles')
<link href="{{ asset('css/main.css') }}" rel="stylesheet">
@endsection

<!-- подключение javascript -->
@section('indexscripts')
<script src="{{ asset('js/indexpage.js') }}"></script>
@endsection