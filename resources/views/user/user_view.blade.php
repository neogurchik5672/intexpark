@extends('layouts.app')
@section('content')
<!-- Скрытые поля для user_id и telegram_id -->
<input type="hidden" id="user-id" value="{{ $user->id }}">
<input type="hidden" id="user-tg-id" value="{{ $user->telegram_id }}">

<!-- Кнопки для админа -->
<div class="adminButtons">
    <div class="adminButtonsEdit" onclick="location.href='/user/user_editing/{{ $user->id }}';">редактировать</div>
    <div class="adminButtonsBlock">заблокировать</div>
    <div class="adminButtonsDelete">удалить</div>
</div>


<!-- Пользователь/история -->
<div class="bodyUser">
    <div class="show">
        <div class="userHeader">
            <div class="user">
                <div class="avatar">
                    <img src="{{ asset('img/Elixir.svg') }}" width="200" height="200" alt="картинка" class="Elixir">
                </div>
                <div class="userValue">
                    <h2> {{"@".$user->username}} </h2>
                    <span><a href=""></a></span>
                </div>
                <div class="valueInputsOuter">
                    <div class="valueInputs">
                        <div class="inputsUser"> ??? exp</div>
                        <div class="inputsUser"> {{" ".$user->balance}}<img src="{{asset('img/коин.svg')}}" width="50" height="50" alt="icon"></div>
                        <div class="inputsUser"> ? <img src="{{asset('img/Vector.svg')}}" alt="icon"></div>
                    </div>
                </div>
            </div>
            
            <div class="myHistory">
                <div class="history-outline">
                    <div class="history" id="history">
                        <span>история покупок</span>
                    </div>
                </div>

                <!-- Модалка с историей покупок -->
                <div class="modalMenuHistory" id="modalMenuHistory">
                    <div class="flexClose">
                        <!-- <div class="closeModalMenu" id="closeModalMenu">X</div> -->
                        <br>
                        <div class="mainModalMenu">
                            <p class="titleModalMenu">История покупок</p>
                            @foreach ($myHistory as $item)
                                <div class="itemHistory">
                                    <div class="left">
                                        <div class="titleHistory">  {{ $item->product->title }} </div>
                                    </div>
                                    <div class="right">
                                        <div class="priceHistory">{{ $item->product->price }}<img src="{{asset('img/коин.svg')}}" alt="icon"></div>
                                        <div class="dateHistory">{{preg_replace('/-/','.', preg_replace('/\s.*/',' ', $item->created_at))}}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </div>
</div>


<!-- Достижения пользователя-->
<div class="achievements-container">
    <div class="achievement-outline">
        <div class="achievement">
            <span>достижения</span>
            <div class="glow-rect" id="rect1"></div>
            <div class="glow-rect" id="rect2"></div>
        </div>
    </div>

    <div class="achievements-scroll-wrapper">
        <div class="achievements-scroll-wrapper-inner">
            <div class="achievements-grid">
                @foreach($achievements as $achievement)
                <div class="achievement-card">
                    <div class="achievement-item">
                        <div class="achievement-icon">
                            <img src="{{ asset('storage/' . $achievement->image) }}"
                                alt="{{ $achievement->name }}"
                                class="achievement-img"
                                onerror="this.src='{{ asset('img/achievementPlaceholder.png') }}'">
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
@endsection

@section('styles')
    <link href="{{ asset('css/user_view_edit.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('js/user_view_edit.js') }}"></script>
@endsection