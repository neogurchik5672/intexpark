@extends('layouts.app')
@section('checkPageAdaptive','eventsLinkAdaptiveCheck')
@section('checkPage','eventsLink')
@section('content')
<link href="{{ asset('css/fireball__banner.css') }}" rel="stylesheet">
<div class="banner">
<img src="{{ asset('img/events/BigFireballLeft.png') }}" alt="" class="big-fireball-left">
<img src="{{ asset('img/events/BigFireballRight.png') }}" alt="" class="big-fireball-right">

<img src="{{ asset('img/events/MiddleFireballRight.png') }}" alt="" class="middle-fireball-right">

<p class="banner__descriptor">упс...</p>
<div class="banner__title">похоже пока<br>событий нет</div>

<img src="{{ asset('img/events/MiddleFireballLeft.png') }}" alt="" class="middle-fireball-left">

<img src="{{ asset('img/events/LittleFireballLeft.png') }}" alt="" class="little-fireball-left">
<img src="{{ asset('img/events/LittleFireballRight.png') }}" alt="" class="little-fireball-right">
</div>
@endsection