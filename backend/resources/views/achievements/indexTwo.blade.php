@extends('layouts.app')

@section('content')
<div class="achievements-container">

    <div class="achievements-header">
        <h2 class="title-h2">Достижения</h2>
    </div>
    
    <div class="achievements-scroll-wrapper">
        <div class="achievements-grid">
            @foreach($achievements as $achievement)
                <div class="achievement-card">
                    <div class="achievement-item">
                        <div class="achievement-icon">
                            {{-- Используем путь к папке public/img --}}
                            <img src="{{ asset('img/' . $achievement->image) }}" 
                                 alt="{{ $achievement->name }}" 
                                 class="achievement-img" 
                                 onerror="this.src='{{ asset('img/coin.png') }}'"> {{--Сейчас проблема с выводом изображения из БД, поэтому подставляется просто изображеие coin.png--}}
                        </div>
                        <div class="achievement-info">
                            <h3>{{ $achievement->name }}</h3>
                            <p>{{ $achievement->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    :root {
        --zheltyy: #fdbc15;
        --t-siniy: #021f3f;
        --fioletovyy: #944ba7;
        --zelenyy: #41bd8f;
        --belyy: #fff;
        --s-zheltyy: #ffe479;
        --t-zheltyy: #cd5602;
        --goluboy: #23bdca;
        --siniy: #085a7f;
        --font-family: "Montserrat", sans-serif;
    }
    
    .achievements-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .title-h2 {
        color: var(--t-siniy);
        text-align: center;
        font-family: var(--font-family);
    }
    .achievements-header {
    background-color: var(--zheltyy); /* Жёлтый цвет из переменных */
    border-radius: 12px;              /* Закругление углов */
    padding: 10px 20px;               /* Внутренний отступ */
    width: 500px ;
    margin: 5 auto 30px;              /* Отцентрировать и отступ снизу */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Лёгкая тень (необязательно) */
    }
    .achievements-scroll-wrapper {
        border: 5px solid var(--zheltyy);
        border-radius: 20px;
        padding: 20px;
    }
    
    .achievements-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .achievement-card {
        background: var(--siniy);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    .achievement-card:hover {
        transform: translateY(-5px);
    }
    
    .achievement-item {
        display: flex;
        padding: 15px;
        height: 100%;
    }
    
    .achievement-icon {
        flex-shrink: 0;
        margin-right: 15px;
    }
    
    .achievement-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;    
    }
    
    .achievement-info {
        flex-grow: 1;
    }
    
    .achievement-info h3 {
        margin: 0 0 8px 0;
        color: var(--belyy);
        font-family: var(--font-family);
    }
    
    .achievement-info p {
        margin: 0;
        color: var(--belyy);
        font-size: 14px;
        line-height: 1.4;
    }
    
    /* Стили для скроллбара */
    .achievements-scroll-wrapper {
        max-height: 600px;
        overflow-y: auto;
    }
    
    .achievements-scroll-wrapper::-webkit-scrollbar {
        width: 8px;
    }
    
    .achievements-scroll-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .achievements-scroll-wrapper::-webkit-scrollbar-thumb {
        background: var(--zheltyy);
        border-radius: 4px;
    }
    
    .achievements-scroll-wrapper::-webkit-scrollbar-thumb:hover {
        background: var(--t-zheltyy);
    }

    @media (max-width: 768px) {
        .achievements-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection