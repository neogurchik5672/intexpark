@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Аккаунт заблокирован</div>

                <div class="card-body text-center">
                    <div class="alert alert-danger">
                        @if(session('message'))
                            {{ session('message') }}
                        @else
                            Ваш аккаунт был заблокирован администратором.
                        @endif
                    </div>
                    
                    <!-- Убираем все ссылки, которые могут вести с этой страницы -->
                    <p>Для выяснения причин обратитесь в поддержку.</p>
                    
                    <!-- Скрываем кнопку выхода -->
                    <style>
                        .logout-form { display: none !important; }
                    </style>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript для предотвращения выхода -->
<script>
    // Блокируем кнопку "Назад" в браузере
    history.pushState(null, null, document.URL);
    window.addEventListener('popstate', function() {
        history.pushState(null, null, document.URL);
    });

    // Блокируем все ссылки на странице
    document.addEventListener('click', function(e) {
        if (e.target.closest('a')) {
            e.preventDefault();
            alert('Ваш аккаунт заблокирован');
        }
    });

    // Блокируем клавиатурные сокращения
    document.addEventListener('keydown', function(e) {
        // Ctrl+W, Ctrl+T, Alt+F4 и т.д.
        if (e.ctrlKey || e.altKey || e.metaKey) {
            e.preventDefault();
        }
    });
</script>
@endsection