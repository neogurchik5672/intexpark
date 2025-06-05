<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="index">
<header>
      <div class="header">
        <div class="">ЛОГО</div>
        <div class="">
          <a class="menu_item_active" href="/">ГЛАВНАЯ</a>
          <a class="" href="{{route('events.index')}}">СОБЫТИЯ</a>
        </div>
        <div class="">
          <a class="" href="{{route('buyRequest.index')}}">{{$userHeader->balance}}<img src="{{asset('img/coin.png')}}" alt="icon"></a>
 <a class=" {{ $userHeader->role == 'admin' ? 'menu-btn' : ''}} " href="{{ $userHeader->role == 'admin' ?  '' : route('user.show')}}">{{ $userHeader->telegram_id }}<img src="{{asset('img/profile.png')}}" alt="icon"></a>
    <div class="socialite-login">
    <a href="{{ route('login.telegram') }}" class="btn btn-telegram">
        <i class="fab fa-telegram"></i> Войти через Telegram
    </a>
</div>
<style>
    .btn-telegram {
        background-color: #0088cc;
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
    }
    .btn-telegram:hover {
        background-color: #0077b5;
        color: white;
    }
</style>
        </div>
      </div>
    </header>
        <div class="wrapper">
	<div class="menu">
		<nav class="menu-list">
      <div class="nameMenu">
        <a class="" href="{{ route('user.show') }}">{{"@".$userHeader->telegram_id }}</a>
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
    <main>
    @yield('content')
    </main> 
    <footer>
        <ul>
          <h1>footer</h1>
            <li><a href='/'>главная</a></li>
            <li><a href={{route('user.show')}}>ЛК</a></li>
            <li><a href={{route('events.index')}}>события и задания</a></li>
            <li><a href={{route('admin.index')}}>админка</a></li>
        </ul> 
    </footer>
    <script src="{{asset('js/index.js')}}"></script>
</body>
</html>