<!DOCTYPE html>
<html>
<head>
    <title>Telegram Mini App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="telegram-web-app-bot-compatible" content="yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--tg-theme-bg-color, #ffffff);
            color: var(--tg-theme-text-color, #000000);
        }
        .container {
            padding: 20px;
            text-align: center;
        }
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="loader" class="loader"></div>
        <div id="app-content" style="display: none;">
            <h1>Welcome, <span id="user-name"></span>!</h1>
            <p>Your balance: <span id="user-balance"></span></p>
            <button onclick="handleLogout()" style="background-color: var(--tg-theme-button-color); color: var(--tg-theme-button-text-color); padding: 10px 20px; border: none; border-radius: 5px;">Logout</button>
        </div>
    </div>

    <script>
        // Функция для автоматической авторизации
        async function autoAuth() {
            try {
                // Получаем данные от Telegram WebApp
                const initData = window.Telegram.WebApp.initData;
                
                // Отправляем данные на сервер для авторизации
                const response = await fetch('/telegram/auto-auth', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: `initData=${encodeURIComponent(initData)}`
                });

                const data = await response.json();
                
                if (data.status === 'success') {
                    // После успешной авторизации показываем контент
                    showAppContent(data.user);
                } else {
                    // Обработка ошибки авторизации
                    console.error('Auth error:', data.error);
                    Telegram.WebApp.showAlert('Authorization failed. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                Telegram.WebApp.showAlert('An error occurred. Please try again.');
            }
        }

        // Функция для показа контента приложения
        function showAppContent(user) {
            document.getElementById('loader').style.display = 'none';
            document.getElementById('app-content').style.display = 'block';
            document.getElementById('user-name').textContent = user.first_name || 'User';
            document.getElementById('user-balance').textContent = user.balance;
        }

        // Функция для выхода
        async function handleLogout() {
            try {
                const response = await fetch('/telegram/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                
                if (data.status === 'success') {
                    Telegram.WebApp.showAlert('You have been logged out');
                    Telegram.WebApp.close();
                }
            } catch (error) {
                console.error('Logout error:', error);
            }
        }

        // При загрузке страницы
        document.addEventListener('DOMContentLoaded', () => {
            // Проверяем, есть ли данные WebApp
            if (window.Telegram && window.Telegram.WebApp && window.Telegram.WebApp.initData) {
                // Пытаемся авторизоваться автоматически
                autoAuth();
            } else {
                // Если данных нет, показываем ошибку
                Telegram.WebApp.showAlert('Telegram auth data not available');
                document.getElementById('loader').style.display = 'none';
            }
        });
    </script>
</body>
</html>