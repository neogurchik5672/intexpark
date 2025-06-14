// Универсальная функция для обработки выбора изображения
function handleImageUpload(wrapper) {
    const input = wrapper.querySelector(".modal__file-input");
    const preview = wrapper.querySelector(".modal__image-preview");
    const placeholder = wrapper.querySelector(".modal__image-placeholder");

    if (input && preview && placeholder) {
        input.addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                    placeholder.style.display = "none";
                };
                reader.readAsDataURL(file);
            }
        });
    }
}

// Инициализация для всех .modal__image-wrapper на странице
document.querySelectorAll(".modal__image-wrapper").forEach((wrapper) => {
    handleImageUpload(wrapper);
});

// Инициализация обработки загрузки изображений для всех .modal__image-wrapper после загрузки страницы
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".modal__image-wrapper").forEach((wrapper) => {
        handleImageUpload(wrapper);
    });
});

// Обработчик для формы создания
document
    .getElementById("createImageInput")
    ?.addEventListener("change", function (e) {
        const file = e.target.files[0];
        const placeholder = document.getElementById("createImagePlaceholder");
        const preview = document.getElementById("createImagePreview");

        if (file && file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = "block";
                placeholder.style.display = "none";
            };
            reader.readAsDataURL(file);
        }
    });

// Клик по превью для смены изображения
document
    .getElementById("createImagePreview")
    ?.addEventListener("click", function () {
        document.getElementById("createImageInput").click();
    });

// Сброс при закрытии модалки
function closeModal(id) {
    const modal = document.getElementById(id);
    if (id === "modalCreate") {
        const preview = document.getElementById("createImagePreview");
        const placeholder = document.getElementById("createImagePlaceholder");
        preview.src = "";
        preview.style.display = "none";
        placeholder.style.display = "flex";
    }
    modal.style.display = "none";
}
document.getElementById("shopSearch").addEventListener("input", function () {
    const term = this.value.toLowerCase();
    document.querySelectorAll(".shop__card").forEach((card) => {
        const name = card.getAttribute("data-name").toLowerCase();
        card.style.display = name.includes(term) ? "block" : "none";
    });
});

// Универсальная функция открытия модалки
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = "flex";
    }
}

// Универсальная функция закрытия модалки
function closeModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;

    const form = modal.querySelector("form");
    const preview = modal.querySelector(".modal__image-preview");
    const placeholder = modal.querySelector(".modal__image-placeholder");

    if (form) form.reset();
    if (preview) {
        preview.src = preview.dataset.originalSrc || "";
        preview.style.display = preview.src ? "block" : "none";
    }
    if (placeholder && !preview?.src) {
        placeholder.style.display = "flex";
    }

    modal.style.display = "none";
}

// Функция для открытия модалки удаления
function openDeleteModal(id, title) {
    document.getElementById(
        "deleteConfirmText"
    ).textContent = `Удалить товар «${title}»?`;
    const form = document.getElementById("deleteForm");
    form.action = `/products/destroy/${id}`;
    openModal("modalDeleteConfirm");
}

// Функция подтверждения сохранения
function confirmSave(formId, message) {
    const form = document.getElementById(formId);
    const fileInput = form.querySelector('input[type="file"][name="img"]');

    // Проверяем, является ли форма формой создания
    const isCreateForm = form.id === "createForm";

    if (fileInput && fileInput.files.length === 0 && !isCreateForm) {
        fileInput.remove(); // Только для редактирования
    }

    // Показываем модалку подтверждения
    document.getElementById("saveConfirmText").textContent = message;
    document.getElementById("confirmSaveBtn").onclick = function () {
        form.submit();
    };
    openModal("modalSaveConfirm");
}

// При нажатии на кнопку "Добавить" для модалки создания
document.getElementById("openAddModal")?.addEventListener("click", function () {
    openModal("modalCreate");
});

// Закрытие всех модалок при клике вне контента
document.querySelectorAll(".modal").forEach((modal) => {
    modal.addEventListener("click", function (e) {
        const content = modal.querySelector(".modal__content");
        if (!content.contains(e.target)) {
            closeModal(modal.id);
        }
    });
});

// Делаем плюс кликабельным для вызова input
document.querySelectorAll(".modal__plus").forEach((plus) => {
    plus.addEventListener("click", function () {
        const fileInput = this.closest(".modal__image-wrapper").querySelector(
            ".modal__file-input"
        );
        if (fileInput) fileInput.click();
    });
});

// При нажатии на кнопку "Добавить" для модалки создания
document.getElementById("openAddModal")?.addEventListener("click", function () {
    const modal = document.getElementById("modalCreate");
    if (modal) {
        const form = modal.querySelector("form");
        if (form) form.reset();

        const imgPreview = modal.querySelector(".modal__image-preview");
        if (imgPreview) {
            imgPreview.src = "";
            imgPreview.style.display = "none";
        }

        const placeholder = modal.querySelector(".modal__image-placeholder");
        if (placeholder) {
            placeholder.style.display = "flex";
        }

        modal.style.display = "flex";
    }
});

// Предпросмотр изображения при выборе нового файла
document.querySelectorAll(".modal__file-input").forEach((input) => {
    input.addEventListener("change", function (e) {
        const file = e.target.files[0];
        const wrapper = input.closest(".modal__image-wrapper");
        const imgPreview = wrapper.querySelector(".modal__image-preview");
        const placeholder = wrapper.querySelector(".modal__image-placeholder");

        if (file && file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function (e) {
                if (imgPreview) {
                    imgPreview.src = e.target.result;
                    imgPreview.style.display = "block";
                }
                if (placeholder) {
                    placeholder.style.display = "none";
                }
            };
            reader.readAsDataURL(file);
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

function toggleVisibility(itemId,itemName) {
    const url = "/admin/product/toggle-visibility/" + itemId;
    const token = document.querySelector('meta[name="csrf-token"]').content;

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const icon = document.getElementById(`visibilityIcon-${itemId}`);
            icon.src = data.is_visible ? ICON_VISIBLE : ICON_HIDDEN;
             // Показываем разные сообщения в зависимости от статуса
            // Показываем уведомление с названием товара
            showNotification(
                data.is_visible
                    ? `Товар "${itemName}" стал видимым`
                    : `Товар "${itemName}" скрыт`
            );
        } else {
            alert('Ошибка при изменении видимости');
        }
    })
    .catch(error => {
        console.error('Ошибка:', error);
        alert('Произошла ошибка. Возможно истекло время сессии.');
    });
}
function showNotification(message) {
    const notification = document.getElementById('notification');

    if (notification) {
        notification.textContent = message;
        notification.classList.add('show');

        // Скрываем через 3 секунды
        setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
    } else {
        // Если нет элемента (например, его не рендерит Blade), создаём временный
        const tempNotification = document.createElement('div');
        tempNotification.id = 'notification';
        tempNotification.className = 'centered-notification success show';
        tempNotification.textContent = message;
        document.body.appendChild(tempNotification);

        setTimeout(() => {
            tempNotification.classList.remove('show');
            setTimeout(() => tempNotification.remove(), 300); // полное удаление после анимации
        }, 3000);
    }
}