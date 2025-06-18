// Получаем элементы для анимации бликов
const rect1 = document.getElementById('rect1');
const rect2 = document.getElementById('rect2');

// Функция для анимации движения вправо
function animateRight() {
    rect1.classList.remove('move-left');
    rect2.classList.remove('move-left');
    rect1.classList.add('move-right');
    rect2.classList.add('move-right');
}

// Функция для анимации движения влево
function animateLeft() {
    rect1.classList.remove('move-right');
    rect2.classList.remove('move-right');
    rect1.classList.add('move-left');
    rect2.classList.add('move-left');
}

// Основная функция для запуска циклической анимации
function runAnimation() {
    animateRight();
    setTimeout(() => {
        animateLeft();
        setTimeout(() => {
            runAnimation(); // Рекурсивный вызов для бесконечной анимации
        }, 4000); // Задержка перед следующим циклом
    }, 4000); // Задержка перед движением влево
}

// Запускаем анимацию при загрузке страницы
runAnimation();

// Поиск товаров в магазине
document.getElementById('shopSearch').addEventListener('input', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('.shop__card').forEach(card => {
        const name = card.getAttribute('data-name').toLowerCase();
        // Показываем/скрываем карточки в зависимости от поискового запроса
        card.style.display = name.includes(term) ? 'block' : 'none';
    });
});

// Функция для открытия модального окна
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'flex';
    }
}

// Функция для закрытия модального окна
function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'none';
    }
}

// Закрытие модального окна при клике вне его содержимого
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', function (e) {
        const content = modal.querySelector('.modal__content');
        if (!content.contains(e.target)) {
            closeModal(modal.id);
        }
    });
});

// Функция для покупки товара
function buyProduct(itemId, price) {
    // Отправка запроса на сервер для покупки товара
    fetch('/buy-product', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            item_id: itemId,
            price: price
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Обновляем интерфейс после успешной покупки
            const button = document.querySelector(`#modalDetails-${itemId} .modalka__button--buy`);
            if (button) {
                button.classList.remove('modalka__button--buy');
                button.classList.add('modalka__button--purchased');
                button.textContent = 'Куплено';
                button.onclick = null;
                
                // Обновляем баланс пользователя, если он есть на странице
                if (data.new_balance !== undefined) {
                    const balanceElement = document.querySelector('.user-balance');
                    if (balanceElement) {
                        balanceElement.textContent = data.new_balance;
                    }
                }
            }
        } else {
            alert(data.message || 'Произошла ошибка при покупке');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Произошла ошибка при отправке запроса');
    });
}