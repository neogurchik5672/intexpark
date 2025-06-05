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
 <a href="{{ route('user.show') }}">{{ $userHeader->telegram_id }}<img src="{{asset('img/profile.png')}}" alt="icon"></a>
        </div>
      </div>
    </header>
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