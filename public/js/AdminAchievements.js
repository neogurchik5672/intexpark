function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'none';
        // Сброс формы и предпросмотра изображения
        const form = modal.querySelector('form');
        const imgPreview = modal.querySelector('.image-preview');
        if (form) form.reset();
        if (imgPreview) {
            imgPreview.style.backgroundImage = 'none';
            imgPreview.style.opacity = '1';
            imgPreview.innerHTML = '<span class="plus-icon">+</span>';
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Поиск достижений 
    document.getElementById('achievementSearch').addEventListener('input', function () {
        const term = this.value.toLowerCase();
        document.querySelectorAll('.achievement-card').forEach(card => {
            const name = card.getAttribute('data-name')?.toLowerCase() || '';
            // card.style.display = name.includes(term) ? 'block' : 'none';
            if (name.includes(term)) {
            card.style.removeProperty('display'); // Возвращаем исходный стиль
        } else {
            card.style.display = 'none';
        }
        });
    });

    // Предпросмотр изображения при добавлении
    const imageUpload = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    if (imageUpload && imagePreview) {
        imageUpload.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.addEventListener('load', function () {
                    imagePreview.style.backgroundImage = `url(${this.result})`;
                    imagePreview.style.backgroundSize = 'auto 90%';
                    imagePreview.style.backgroundRepeat = 'no-repeat';
                    imagePreview.style.backgroundPosition = 'center';
                    imagePreview.style.opacity = '0.5';
                    imagePreview.querySelector('.plus-icon')?.remove();
                });
                reader.readAsDataURL(file);
            }
        });
    }

    // Открытие модального окна добавления
    document.querySelector('.button__add').addEventListener('click', function () {
        document.getElementById('achievementModal').style.display = 'block';
    });

    // Модальное окно удаления
    const deleteModal = document.getElementById('deleteConfirmModal');
    const achievementNameElem = document.getElementById('achievementNameToDelete');
    const deleteForm = document.getElementById('deleteForm');

    document.querySelectorAll('.open-delete-modal').forEach(button => {
        button.addEventListener('click', function () {
            const name = this.getAttribute('data-name');
            const id = this.getAttribute('data-id');
            achievementNameElem.textContent = '«' + name + '»';
            deleteForm.setAttribute('action', '/admin/achievements/' + id);
            deleteModal.style.display = 'block';
        });
    });

    // Закрытие по клику вне окна — удаление
    window.addEventListener('click', function (event) {
        if (event.target === deleteModal) {
            deleteModal.style.display = 'none';
        }
    });

    // Модальное окно редактирования
    const editModal = document.getElementById('editAchievementModal');
    const editForm = document.getElementById('editAchievementForm');

    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const card = this.closest('.achievement-card');
            const name = card.querySelector('h3').innerText.trim();
            const description = card.querySelector('p').innerText.trim();
            const coins = card.querySelector('.coins').innerText.replace('+', '').trim();
            const imageSrc = card.querySelector('.achievement-img').src;
            const requiredCount = card.getAttribute('data-required-count');
            const achievementId = this.dataset.id;

            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_intexcoin').value = coins;
            document.getElementById('edit_required_count').value = requiredCount;

            const preview = document.getElementById('editImagePreview');
            preview.style.backgroundImage = `url(${imageSrc})`;
            preview.style.backgroundSize = 'auto 90%';
            preview.style.backgroundRepeat = 'no-repeat';
            preview.style.backgroundPosition = 'center';
            preview.style.opacity = '0.5';
            if (preview.querySelector('.plus-icon')) {
                preview.querySelector('.plus-icon').remove();
            }

            editForm.setAttribute('action', '/admin/achievements/' + achievementId);
            editModal.style.display = 'block';
        });
    });

    // Предпросмотр нового изображения при редактировании
    const editImageInput = document.getElementById('edit_image');
    const editImagePreview = document.getElementById('editImagePreview');
    if (editImageInput && editImagePreview) {
        editImageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    editImagePreview.style.backgroundImage = `url(${e.target.result})`;
                    editImagePreview.style.backgroundSize = 'auto 90%';
                    editImagePreview.style.backgroundRepeat = 'no-repeat';
                    editImagePreview.style.backgroundPosition = 'center';
                    editImagePreview.style.opacity = '0.5';
                    if (editImagePreview.querySelector('.plus-icon')) {
                        editImagePreview.querySelector('.plus-icon').remove();
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Закрытие по клику вне окна — редактирование
    window.addEventListener('click', function (event) {
        if (event.target === editModal) {
            closeModal('editAchievementModal');
        }
    });

    // Закрытие по клику вне окна — добавление
    window.addEventListener('click', function (event) {
        const modal = document.getElementById('achievementModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Показываем уведомление по центру
    window.addEventListener('DOMContentLoaded', function () {
        const notification = document.getElementById('notification');
        if (notification) {
            notification.classList.add('show');

            // Скрываем через 3 секунды
            setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
    }
});
});

function toggleAchievementVisibility(Id) {
    const url = "/admin/achievement/toggle-visibility/" + Id;
    const token = document.querySelector('meta[name="csrf-token"]').content;

    fetch(url, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": token,
            "Content-Type": "application/json",
        },
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        return response.json();
    })
    .then((data) => {
        if (data.success) {
            const icon = document.getElementById(
                `visibilityIcon-${Id}`
            );
            icon.src = data.is_visible
                ? ICON_VISIBLE
                : ICON_HIDDEN;
        } else {
            alert("Ошибка при изменении видимости");
        }
    })

    .catch((error) => {
        console.error("Ошибка:", error);
        alert("Произошла ошибка. Возможно истекло время сессии.");
    });
}