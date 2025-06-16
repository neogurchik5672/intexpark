// Убедимся, что скрипт выполняется после загрузки DOM
document.addEventListener('DOMContentLoaded', function () {

    // const notification = document.getElementById('notification');
    // Если уведомление есть — покажем его
    // if (notification && notification.textContent.trim() !== '') {
    //     notification.classList.add('show');

    //     setTimeout(() => {
    //         notification.classList.remove('show');
    //         setTimeout(() => {
    //             notification.textContent = ''; // очищаем текст
    //         }, 300);
    //     }, 3000);
    // }
    // Для динамических уведомлений
// function showNotification(message, type = 'success') {
//     const notification = document.getElementById('notification');

//     if (notification) {
//         notification.textContent = message;
//         notification.className = 'centered-notification'; // сброс
//         notification.classList.add(type, 'show');

//         setTimeout(() => {
//             notification.classList.remove('show');
//             setTimeout(() => {
//                 notification.textContent = ''; // очищаем текст
//             }, 300);
//         }, 3000);
//     }
// }

    // Модальное окно для истории покупок
    const history = document.querySelector('.history');
    const modalMenuHistory = document.getElementById('modalMenuHistory');

    if (history && modalMenuHistory) {
        history.addEventListener('click', function () {
            modalMenuHistory.style.display = 'flex';
        });

        modalMenuHistory.addEventListener('click', function (e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });
    }

    // Модальное окно для списка достижений
    const achievementCardAdd = document.querySelector('.achievement-card-add');
    const modalMenuAddAchivement = document.getElementById('modalMenuAddAchivement');
    let selectedAchievementId = null;
    let pendingAchievements = [];
    let pendingDeletions = [];
    let pendingBalance = null;

    if (achievementCardAdd && modalMenuAddAchivement) {
        achievementCardAdd.addEventListener('click', function () {
            modalMenuAddAchivement.style.display = 'flex';
        });

        modalMenuAddAchivement.addEventListener('click', function (e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });
    }

    // Выбор достижения
    document.querySelectorAll('.achievement-card-list').forEach(card => {
        card.addEventListener('click', function () {
            document.querySelectorAll('.achievement-card-list').forEach(c => {
                c.classList.remove('selected');
            });
            this.classList.add('selected');
            selectedAchievementId = this.dataset.id;
        });
    });

    // Поиск по достижениям в модальном окне
    const searchInput = document.getElementById('achievementSearch-list');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const term = this.value.toLowerCase();
            document.querySelectorAll('.achievement-card-list').forEach(card => {
                const name = card.getAttribute('data-name').toLowerCase();
                card.style.display = name.includes(term) ? 'flex' : 'none';
            });
        });
    }

    // Модальное окно
    function showModal(message, buttons = [], onConfirm = null, onCancel = null, input = null) {
        const modal = document.createElement('div');
        modal.className = 'custom-modal';
        modal.innerHTML = `
            <div class="custom-modal-content">
                <p>${message}</p>
                ${input ? `<input type="number" id="balanceInput" placeholder="${input.placeholder}" value="${input.value || ''}" style="margin-bottom: 20px; padding: 10px; border-radius: 10px; border: none; width: 80%; font-family: var(--font-family); font-size: 16px;">` : ''}
                <div class="modal-buttons">
                    ${buttons.map(btn => `
                        <button style="background-color: ${btn.color}; color: white;" onclick="${btn.action}">${btn.text}</button>
                    `).join('')}
                </div>
            </div>
        `;
        document.body.appendChild(modal);

        modal.querySelectorAll('.modal-buttons button').forEach((btn, index) => {
            btn.addEventListener('click', () => {
                if (index === 0 && onConfirm) onConfirm(modal.querySelector('#balanceInput')?.value);
                if (index === 1 && onCancel) onCancel();
                modal.remove();
            });
        });

        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.remove();
            }
        });
    }

    // Редактирование количества интекскоинов
    const coinsDiv = document.getElementById('inputsUserCoins');
    if (coinsDiv) {
        coinsDiv.addEventListener('click', function () {
            const userTgId = document.getElementById('user-tg-id')?.value || null;
            const currentBalance = parseInt(coinsDiv.textContent.trim().split(' ')[0]) || 0;
            if (!userTgId) {
                showModal('Ошибка: tg_id пользователя не найден.');
                return;
            }

            showModal(
                `Редактирование количества интекскоинов у пользователя @${userTgId}`,
                [
                    { text: 'Сохранить', color: '#41BD8F', action: 'saveBalance()' },
                    { text: 'Выйти', color: '#085A7F', action: 'cancelBalance()' }
                ],
                (newBalance) => {
                    const balanceNum = parseInt(newBalance, 10);
                    if (isNaN(balanceNum) || balanceNum < 0) {
                        showModal('Пожалуйста, введите корректное число.');
                        return;
                    }
                    pendingBalance = balanceNum;
                    coinsDiv.innerHTML = `${balanceNum} <img src="/img/коин.svg" width="50" height="50" alt="coin">`;
                },
                () => {},
                { placeholder: currentBalance, value: currentBalance }
            );
        });
    }

    // Добавление достижения
    const addAchievementButton = document.querySelector('.adminButtonsAddAchivement');
    if (addAchievementButton) {
        addAchievementButton.addEventListener('click', function (e) {
            e.preventDefault();
            if (!selectedAchievementId) {
                showModal('Пожалуйста, выберите достижение!');
                return;
            }

            const userId = document.getElementById('user-id')?.value || null;
            const userTgId = document.getElementById('user-tg-id')?.value || userId;
            if (!userId) {
                showModal('Ошибка: ID пользователя не найден.');
                return;
            }

            const selectedCard = document.querySelector(`.achievement-card-list[data-id="${selectedAchievementId}"]`);
            const achievementName = selectedCard.getAttribute('data-name');
            const achievementImage = selectedCard.querySelector('.achievement-img').src;
            const achievementCoins = selectedCard.querySelector('.coins-list').textContent;
            const achievementDescription = selectedCard.querySelector('.achievement-info-list h3')?.nextElementSibling?.textContent || 'Описание отсутствует';

            pendingAchievements.push({
                id: selectedAchievementId,
                name: achievementName,
                image: achievementImage,
                coins: achievementCoins,
                description: achievementDescription
            });

            const newCard = document.createElement('div');
            newCard.classList.add('achievement-card');
            newCard.setAttribute('data-id', selectedAchievementId);
            newCard.innerHTML = `
                <div class="achievement-item">
                    <div class="achievement-icon">
                        <img src="${achievementImage}" alt="${achievementName}" class="achievement-img" onerror="this.src='/img/Coin.png'">
                    </div>
                    <div class="achievement-info">
                        <h3>${achievementName}</h3>
                        <p>${achievementDescription}</p>
                    </div>
                </div>
                <div class="achievement-coins">
                    <img src="/img/коин.svg" class="coin-icon">
                    <span class="coins">${achievementCoins}</span>
                </div>
                <div class="achievement-cart">
                    <img src="/img/trash.svg" class="trash-icon" width="35" height="35" alt="trash">
                </div>
            `;

            const achievementsGrid = document.querySelector('.achievements-grid');
            const addCard = document.querySelector('.achievement-card-add');
            if (achievementsGrid && addCard) {
                achievementsGrid.insertBefore(newCard, addCard);
            } else {
                achievementsGrid.appendChild(newCard);
            }

            showModal(`Достижение добавлено пользователю @${userTgId}`);
            modalMenuAddAchivement.style.display = 'none';
            selectedAchievementId = null;
        });
    }

    // Удаление достижения
    document.querySelector('.achievements-grid').addEventListener('click', function (e) {
        if (e.target.closest('.achievement-cart')) {
            const card = e.target.closest('.achievement-card');
            const achievementId = card.getAttribute('data-id');
            const achievementName = card.querySelector('.achievement-info h3').textContent;
            const userTgId = document.getElementById('user-tg-id')?.value || null;

            if (achievementId && userTgId) {
                showModal(
                    `Удалить достижение "${achievementName}" у пользователя @${userTgId}?`,
                    [{ text: 'Удалить', color: '#CD5602', action: 'confirmDelete()' }],
                    () => {
                        card.remove();
                        if (!pendingDeletions.includes(achievementId)) {
                            pendingDeletions.push(achievementId);
                        }
                        pendingAchievements = pendingAchievements.filter(a => a.id !== achievementId);
                    }
                );
            }
        }
    });

    // Сохранение изменений
    const saveButton = document.querySelector('.adminButtonsSave');
    if (saveButton) {
        saveButton.addEventListener('click', function (e) {
            e.preventDefault();
            const userId = document.getElementById('user-id')?.value || null;
            if (!userId) {
                showModal('Ошибка: ID пользователя не найден.');
                return;
            }

            if (pendingAchievements.length === 0 && pendingDeletions.length === 0 && pendingBalance === null) {
                showModal('Изменения сохранены.', [], () => {
                    window.location.href = `/user/user_view/${userId}`;
                });
                return;
            }

            fetch('/user/update-user-data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    user_id: userId,
                    achievement_ids: pendingAchievements.map(a => a.id),
                    delete_achievement_ids: pendingDeletions,
                    balance: pendingBalance
                })
            })
            .then(response => {
                if (response.status === 403) {
                    throw new Error('Доступ запрещен.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    pendingAchievements = [];
                    pendingDeletions = [];
                    pendingBalance = null;
                    showModal('Изменения сохранены.', [], () => {
                        window.location.href = `/user/user_view/${userId}`;
                    });
                } else {
                    showModal('Ошибка: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                showModal('Произошла ошибка при сохранении данных: ' + error.message);
            });
        });
    }

    // Выход с подтверждением
    const exitButton = document.querySelector('.adminButtonsExit');
    if (exitButton) {
        exitButton.addEventListener('click', (e) => {
            e.preventDefault();
            const userId = document.getElementById('user-id')?.value || '';
            if (pendingAchievements.length > 0 || pendingDeletions.length > 0 || pendingBalance !== null) {
                showModal('Вы не сохранили изменения!', [
                    { text: 'Сохранить', color: '#41BD8F', action: 'saveAndRedirect()' },
                    { text: 'Выйти', color: '#944BA7', action: 'exitWithoutSaving()' }
                ], saveAndRedirect, exitWithoutSaving);
            } else {
                window.location.href = `/user/user_view/${userId}`;
            }
        });
    }

    // Удаление пользователя
    const deleteButton = document.querySelector('.adminButtonsDelete');
    if (deleteButton) {
        deleteButton.addEventListener('click', function (e) {
            e.preventDefault();
            const userId = document.getElementById('user-id')?.value || null;
            const userTgId = document.getElementById('user-tg-id')?.value || null;
            if (!userId || !userTgId) {
                showModal('Ошибка: данные пользователя не найдены.');
                return;
            }

            showModal(
                `Удалить @${userTgId} пользователя?`,
                [
                    { text: 'Удалить', color: '#CD5602', action: 'confirmDeleteUser()' },
                    { text: 'Выйти', color: '#085A7F', action: 'cancelDeleteUser()' }
                ],
                () => {
                    fetch('/user/delete-user', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                        },
                        body: JSON.stringify({
                            user_id: userId
                        })
                    })
                    .then(response => {
                        if (response.status === 403) {
                            throw new Error('Доступ запрещен.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            showModal(`Пользователь @${userTgId} удален.`, [], () => {
                                window.location.href = data.redirect || '/user';
                            });
                        } else {
                            showModal('Ошибка: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка:', error);
                        showModal('Произошла ошибка при удалении пользователя: ' + error.message);
                    });
                }
            );
        });
    };

    // Функции для модального окна
    window.saveAndRedirect = function () {
        const userId = document.getElementById('user-id')?.value || null;
        if (!userId) {
            showModal('Ошибка: ID пользователя не найден.');
            return;
        }

        if (pendingAchievements.length === 0 && pendingDeletions.length === 0 && pendingBalance === null) {
            showModal('Изменения сохранены.', [], () => {
                window.location.href = `/user/user_view/${userId}`;
            });
            return;
        }

        fetch('/user/update-user-data', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || ''
            },
            body: JSON.stringify({
                user_id: userId,
                achievement_ids: pendingAchievements.map(a => a.id),
                delete_achievement_ids: pendingDeletions,
                balance: pendingBalance
            })
        })
        .then(response => {
            if (response.status === 403) {
                throw new Error('Доступ запрещен.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                pendingAchievements = [];
                pendingDeletions = [];
                pendingBalance = null;
                showModal('Изменения сохранены.', [], () => {
                    window.location.href = `/user/user_view/${userId}`;
                });
            } else {
                showModal('Ошибка: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            showModal('Произошла ошибка при сохранении изменений: ' + error.message);
        });
    };

    window.exitWithoutSaving = function () {
        const userId = document.getElementById('user-id')?.value || null;
        pendingAchievements = [];
        pendingDeletions = [];
        pendingBalance = null;
        window.location.href = userId ? `/user/user_view/${userId}` : '/user/account';
    };

    // Функции для модальных окон
    window.confirmDelete = function () {};
    window.saveBalance = function () {};
    window.cancelBalance = function () {};
    window.confirmDeleteUser = function () {};
    window.cancelDeleteUser = function () {};
});