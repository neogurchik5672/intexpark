<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="/css/style.css">
    @yield('styles')
</head>

<body class="index">
    <header>
        <div class="header">
            <div id="checkPage" class="defaultPage @yield('checkPage')">
                <span class="">ИНТЕКСПАРК</span>
                <a class="main" href="/">ГЛАВНАЯ</a>
                <a class="events" href="{{ route('events.index') }}">СОБЫТИЯ</a>
            </div>
            <div class="rightHeader">
                <a class="" href="{{ route('buyRequest.index') }}">{{ $userHeader->balance }}<img
                        src="{{ asset('img/coin.png') }}" alt="icon"></a>
                <a class=" {{ $userHeader->role == 'admin' ? 'menu-btn' : '' }} "
                    href="{{ $userHeader->role == 'admin' ? '' : route('user.show') }}">{{ $userHeader->telegram_id }}<img
                        src="{{ asset('img/profile.png') }}" alt="icon"></a>
                <a href="{{ route('user.show') }}">{{ '@' . $userHeader->tg_id }}<img
                        src="{{ asset('img/profile.png') }}" alt="icon"></a>
            </div>
        </div>
    </header>
    <div class="wrapper">
        <div class="menu">
            <nav class="menu-list">
                <div class="nameMenu">
                    <a class="" href="{{ route('user.show') }}">{{ '@' . $userHeader->telegram_id }}</a>
                </div>
                <div class="contentMenu">
                    <a href="{{ route('user.index') }}">пользователи</a>
                    <a href="/achievements">достижения</a>
                    <a href="{{ route('buyRequest.index') }}">магазин</a>
                    <a href="{{ route('events.index') }}">события</a>
            </nav>
        </div>
    </div>
    </div>
	</div>
{{-- шапка для телефонов --}}
<div class="headerAdaptive">
  <div class="flexMenuAdaptive">
  <div class="logo">ИНТЕКСПАРК</div>
    <div class="menuButtonAdaptive">
      <div class="lineButtonMenu"></div>
      <div class="lineButtonMenu"></div>
      <div class="lineButtonMenu"></div>
    </div>
    <div class="closeMenuButtonAdaptive">
      <img src="{{asset('img/burgerClose.png')}}" alt="icon">
    </div>
  </div>
  </div>
  <div class="wrapperAdaptive">
	<div class="menuAdaptive">
		<nav class="menu-listAdaptive">
      <div class="nameMenuAdaptive">
        <a class="" href="{{ route('user.show') }}">{{"@".$userHeader->telegram_id }}</a>
      </div>
      <div class="coinMenuAdaptive">
        <a class="" href="#">{{$userHeader->balance}}<img src="{{asset('img/coin.png')}}" alt="icon"></a>
      </div>
      <div class="contentMenuAdaptive @yield('checkPageAdaptive')">
      <div class="mainLinkAdaptive"><a class="menuLinkAdaptive" href="/">ГЛАВНАЯ</a></div>
			<div class="eventsLinkAdaptive"><a class="menuLinkAdaptive" href="{{route('events.index')}}">СОБЫТИЯ</a></div>
			<div class="profileLinkAdaptive"><a class="menuLinkAdaptive" href="{{ route('user.show') }}">ПРОФИЛЬ</a></div>
		</nav>
    </div>
	</div>
    <main>
        @yield('content')
    </main>
    <footer>
        <ul>
            <h1>footer</h1>
            <li><a href='/'>главная</a></li>
            <li><a href={{ route('user.show') }}>ЛК</a></li>
            <li><a href={{ route('events.index') }}>события и задания</a></li>
            <li><a href={{ route('admin.index') }}>админка</a></li>
        </ul>
    </footer>
    <script type="module" src="{{asset('js/index.js')}}"></script>
    <script src="{{ asset('js/index.js') }}"></script>
    @yield('scripts')
</body>

</html>
