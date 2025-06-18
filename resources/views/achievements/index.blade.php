@extends('layouts.app')

@section('content')

<div class="achievements-container">
    <div class="achievement-outline">
        <div class="achievement">
            <span>достижения</span>
            <div class="glow-rect" id="rect1"></div>
            <div class="glow-rect" id="rect2"></div>
        </div>
    </div>

    <div class="achievements-scroll-wrapper">
        <div class="achievements-grid">
            @foreach($achievements as $achievement)
            <div class="achievement-card">
                <div class="achievement-item">
                    <div class="achievement-icon">
                        <img src="{{ asset('storage/' . $achievement->image) }}"
                            alt="{{ $achievement->name }}"
                            class="achievement-img"
                            onerror="this.src='{{ asset('storage/img/coin.png') }}'">
                    </div>
                    <div class="achievement-info">
                        <h3>{{ $achievement->name }}</h3>
                        <p>{{ $achievement->description }}</p>
                    </div>
                </div>

                <!-- Блок с монеткой и количеством -->
                <div class="achievement-coins">
                    <img src="{{ asset('storage/img/coin.png') }}" class="coin-icon">
                    <span class="coins">+{{ $achievement->intexcoin }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script>
    const rect1 = document.getElementById('rect1');
    const rect2 = document.getElementById('rect2');

    function animateRight() {
        rect1.classList.remove('move-left');
        rect2.classList.remove('move-left');
        rect1.classList.add('move-right');
        rect2.classList.add('move-right');
    }

    function animateLeft() {
        rect1.classList.remove('move-right');
        rect2.classList.remove('move-right');
        rect1.classList.add('move-left');
        rect2.classList.add('move-left');
    }

    function runAnimation() {
        animateRight();
        setTimeout(() => {
            animateLeft();
            setTimeout(() => {
                runAnimation();
            }, 3000); // Задержка 3с перед следующим циклом
        }, 3000); // Задержка 3с перед движением влево
    }

    // Запускаем анимацию
    runAnimation();
</script>
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
        --font-family: 'Montserrat-Regular', 'sans-serif';
        --fon: linear-gradient(180deg,
                rgba(2, 31, 63, 1) 7.925131916999817%,
                rgba(4, 73, 115, 1) 50%,
                rgba(35, 189, 202, 1) 100%);

    }

    @font-face {
        font-family: 'Montserrat-bold';
        src: url(/backend/public/fonts/Montserrat-Bold.woff2) format("woff2");
    }


    .coins {
        color: var(--belyj, #ffffff);
        text-align: left;
        font-family: "Montserrat-Regular", sans-serif;
        font-size: 16px;
        font-weight: 400;
        position: relative;
    }


    .achievement-outline {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: var(--zheltyy);
        width: 368px;
        height: 64px;
        border-radius: 32px;
        position: absolute;
        margin-top: -30px;
        z-index: 1;

    }

    .achievement {
        display: flex;
        position: relative;
        width: 346px;
        height: 46px;
        border-radius: 26px;
        background-color: #FDBC15;
        border: 2px solid #CD5602;

        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-family);
        font-weight: bold;
        text-transform: uppercase;
        overflow: hidden;
    }

    .achievement span {
        color: #021F3F;
        font-size: 24px;
        font-weight: regular;
        font-family: Montserrat-Black;

    }

    .glow-rect {
        position: absolute;
        background-color: #FFE479;
        transform: rotate(-30deg);
        opacity: 1;
    }

    #rect1 {
        width: 49px;
        height: 223px;
        top: -58.06px;
        left: 3.96px;
    }

    #rect2 {
        width: 15px;
        height: 223px;
        top: -58.06px;
        left: 67.69px;
        /* 3.96 + 15 (ширина rect1) + 15 (расстояние) */
    }

    @keyframes moveRight {
        0% {
            transform: translateX(-400px) rotate(30deg);
        }

        100% {
            transform: translateX(400px) rotate(30deg);
        }
    }

    @keyframes moveLeft {
        0% {
            transform: translateX(400px) rotate(30deg);
        }

        100% {
            transform: translateX(-400px) rotate(30deg);
        }
    }

    .move-right {
        animation: moveRight 1.2s linear forwards;
    }

    .move-left {
        animation: moveLeft 1.4s linear forwards;
    }


    .achievements-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;

    }

    .achievements-scroll-wrapper {
        border: 5px solid var(--zheltyy);
        border-radius: 20px;
        padding: 70px 20px 20px;
        max-height: 600px;
        overflow-y: auto;

    }

    .achievements-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;

    }

    .achievement-card {
        position: relative;
        /* Важно для позиционирования дочерних абсолютных элементов */
        background: var(--siniy);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 27px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;

    }

    .achievement-item {
        display: flex;
        flex-grow: 1;

    }

    .achievement-coins {
        position: absolute;
        bottom: 20px;
        right: 25px;
        display: flex;
        align-items: center;
        gap: 5px;
        color: var(--belyy);
        font-family: Montserrat-Regular, sans-serif;
        font-size: 14px;

    }

    .coin-icon {
        width: 30px;
        height: 30px;

    }

    .achievement-img {
        width: 90px;
        width: 100%;
        height: 90px;
        object-fit: cover;

    }

    .achievement-info {
        flex-grow: 1;
    }

    .achievement-info h3 {
        margin: 0 0 8px 0;
        color: var(--belyy);
        font-family: var(--font-family);
        font-family: Montserrat-Regular;
    }

    .achievement-info p {
        white-space: pre-line;
        margin: 0;
        margin-right: 17%;
        color: var(--belyy);
        font-size: 14px;
        line-height: 1.4;
    }

    main {
        margin-top: 220px;

    }

    .achievement-icon {
        flex-shrink: 0;
        margin-right: 10px;
        /* Было, например, 15px — теперь меньше */

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
    .achievement-info {
    flex-grow: 1;
    overflow: hidden;
}

.achievement-info h3 {
    margin: 0 0 8px 0;
    color: var(--belyy);
    font-family: var(--font-family);
    font-family: Montserrat-Regular;
    white-space: wrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.achievement-info p {
    white-space: normal; /* Разрешаем перенос строк */
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Ограничиваем до 3 строк */
    -webkit-box-orient: vertical;
}

    @media (max-width: 768px) {
        .achievements-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@endsection