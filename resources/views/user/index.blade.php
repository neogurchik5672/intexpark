@extends('layouts.app')
@section('content')
<div class="indexAllUsers">
    <div class="flexAllUsers">
    <div class="titleAllUsers">
        <span>Пользователи</span>
    <form class="formUser" action="{{route('user.index')}}">
          <input type="search" autocomplete="off" autofocus placeholder="Поиск" name="search" id="search">
    </form>
    </div>
    <div class="marginScrollAllUsers">
    <div class="flexScrollUlUser">
<div class="scrollAllUsersUl">
        <ul class="ulUser">          
    @foreach ($query as $item)
            <li class="hide">
                   <a id="userId" href="{{route('user.all',$item->id)}}"><span>{{"@".$item->telegram_id}}</span></a>
            </li>
    @endforeach
        </ul>
</div>
    </div>
    </div>
    <div class="scrollbarMainAllUsers">
    <div class="mainAllUsers">
    @foreach ($query as $item)
        <div class="item">
            <div class="userId">
            <a id="userId" href="{{route('user.all',$item->id)}}"><span>{{"@".$item->telegram_id}}</span></a>
            </div>
            <div class="iconsAllUsers">
            <span id="coinModalOpen">
            <div class="coinModalMenu">
            <span>                
                <div class="">
               <div class="textModalMenu"> РЕДАКТИРОВАТЬ КОЛИЧЕСТВО ИНТЕКСКОИНОВ У ПОЛЬЗОВАТЕЛЯ </div>
              {{"@".$item->telegram_id}}
              </div>
            </span><br>
                <form data-name="{{$item->telegram_id}}" data-id="{{$item->id}}" enctype="multipart/form-data" action="{{route('user.updateCoins',$item->id)}}" method="POST">
                @csrf
                @method('PUT') <!-- Метод PUT для обновления ресурса -->
                <div class="valueModalMenu">
                <input type="number" name="balance" min="1" id="balance" value="{{$item->balance}}">
                   <img src="{{asset('img/coin.png')}}">
                   </div>
                   <div class="buttonsModalMenu"> 
                <div class="closeCoinModalMenu">ВЫЙТИ</div>
                <button type="submit">СОХРАНИТЬ</button> 
                  </div>
                </form>
           </div>
                 <img id="coinModalImg" onmouseout="this.src='{{asset('img/coin.svg')}}'" onmouseover="this.src='{{asset('img/coinHover.png')}}'" src="{{asset('img/coin.svg')}}">
            </span>
            <a href="{{route('user.all',$item->id)}}">
                 <img onmouseout="this.src='{{asset('img/edit.svg')}}'" onmouseover="this.src='{{asset('img/editHover.png')}}'" src="{{asset('img/edit.svg')}}">
            </a>
            <span id="LockModalOpen">
                   <img onmouseout="this.src='{{asset('img/lock.svg')}}'" onmouseover="this.src='{{asset('img/lockHover.svg')}}'" src="{{asset('img/lock.svg')}}">
            </span>
            <span id="trashModalOpen">
                <div class="trashModalMenu">
            <span>
               <div class="">
               <div class="textModalMenu">
                УДАЛИТЬ 
                  {{"@".$item->telegram_id}}
                 ПОЛЬЗОВАТЕЛЯ?
                </div>
               </div>
            </span><br>
            <form id="formTrashModal" data-id="{{$item->id}}" action="{{route('user.remove',$item->id)}}" method="POST">
                @csrf
                   <div class="buttonsModalMenu"> 
                    <div class="closeTrashModalmenu">ВЫЙТИ</div>
                    <button>УДАЛИТЬ</button>
                   </div>
                 <div class="trashSuccess">ПОЛЬЗОВАТЕЛЬ {{"@".$item->telegram_id}} УДАЛЕН</div>
                </form>
           </div>    
               <img id="trashModalImg" onmouseout="this.src='{{asset('img/trash.svg')}}'" onmouseover="this.src='{{asset('img/trashHover.png')}}'" src="{{asset('img/trash.svg')}}">
            </span>
            <span id="addAdminModalOpen">
            <div class="addAdminModalMenu">
            @if ($item->role != 'admin')
            <span>НАЗНАЧИТЬ ПОЛЬЗОВАТЕЛЯ 
                {{"@".$item->telegram_id}} 
            АДМИНОМ
            </span>
                  <form id="formAddAdminModal" data-id="{{$item->id}}" enctype="multipart/form-data" action="{{route('admin.newAdmin',$item->id)}}" method="POST">
                @csrf
                @method('PUT') <!-- Метод PUT для обновления ресурса -->
                   <div class="buttonsModalMenu"> 
                  <div class="closeAddAdminMenu">ВЫЙТИ</div>
                  <button>НАЗНАЧИТЬ</button>
                   </div>
                   <div class="addAdminSuccess">
                    ПОЛЬЗОВАТЕЛЬ {{"@".$item->telegram_id}} ТЕПЕРЬ АДМИН
                   </div>
                  </form>
                  @else
                  <span class="isAdmin">ПОЛЬЗОВАТЕЛЬ УЖЕ АДМИН</span><br>
                   <div class="buttonsModalMenu"> 
                  <div class="closeAddAdminMenu">ВЫЙТИ</div>
                   </div>
                  @endif
                </div>    
               <div id="addAdminModalImg" title="Назначить админом" class=""> + </div>
            </span>
           </div>
           <div class="lockModalMenu">
            <span>
                ЗАБЛОКИРОВАТЬ 
                  {{"@".$item->telegram_id}}
                 ПОЛЬЗОВАТЕЛЯ?
            </span>
            <div class="closeLockModalmenu">ВЫЙТИ</div>
            <button>ЗАБЛОКИРОВАТЬ</button>
           </div> 
        </div>
           @endforeach
        </div>
        </div>
@endsection