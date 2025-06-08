<script src="https://telegram.org/js/telegram-web-app.js"></script>
<script>
    const user = window.Telegram.WebApp.initDataUnsafe.user;

    fetch("/api/telegram-login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": '{{ csrf_token() }}'
        },
        body: JSON.stringify(user)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect_url;
        } else {
            alert('Ошибка авторизации');
        }
    });
</script>