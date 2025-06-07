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
    
    // Открытие модального окна
    document.querySelector('.button__add').addEventListener('click', function () {
        document.getElementById('achievementModal').style.display = 'block';
    });

    // Закрытие по клику на крестик
    document.getElementById('closeModalBtn').addEventListener('click', function () {
        document.getElementById('achievementModal').style.display = 'none';
    });

    // Закрытие по клику вне окна
    window.addEventListener('click', function (event) {
        const modal = document.getElementById('achievementModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('achievementSearch').addEventListener('input', function () {
            const term = this.value.toLowerCase();
            document.querySelectorAll('.achievement-card').forEach(card => {
                const name = card.getAttribute('data-name')?.toLowerCase() || '';
                card.style.display = name.includes(term) ? 'block' : 'none';
            });
        });
        
        // Обработчик для предпросмотра изображения
        const imageUpload = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        
        if (imageUpload && imagePreview) {
            imageUpload.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    
                   reader.addEventListener('load', function() {
    imagePreview.style.backgroundImage = `url(${this.result})`;
    imagePreview.style.backgroundSize = 'auto 90%'; /* ограничьте размер */
    imagePreview.style.backgroundRepeat = 'no-repeat';
    imagePreview.style.backgroundPosition = 'center';
    imagePreview.style.opacity = '0.5';
    imagePreview.querySelector('.plus-icon')?.remove();
});
                    
                    reader.readAsDataURL(file);
                }
            });
        }
    });
   

document.querySelectorAll('.btn-delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (confirm('Вы уверены, что хотите удалить эту ачивку?')) {
            this.submit();
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteConfirmModal');
    const closeDeleteBtn = document.getElementById('closeDeleteModalBtn');
    const achievementNameElem = document.getElementById('achievementNameToDelete');
    const deleteForm = document.getElementById('deleteForm');

    // При клике на кнопку "Удалить"
    document.querySelectorAll('.open-delete-modal').forEach(button => {
        button.addEventListener('click', function () {
            const name = this.getAttribute('data-name');
            const id = this.getAttribute('data-id');

            // Отображаем название ачивки
            achievementNameElem.textContent = '«' + name + '»';

            // Обновляем action формы
            deleteForm.setAttribute('action', '/admin/achievements/' + id);

            // Показываем модалку
            deleteModal.style.display = 'block';
        });
    });

    // Закрытие по крестику
    closeDeleteBtn.addEventListener('click', function () {
        deleteModal.style.display = 'none';
    });

    // Закрытие по клику вне окна
    window.addEventListener('click', function (event) {
        if (event.target === deleteModal) {
            deleteModal.style.display = 'none';
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editAchievementModal');
    const closeEditModalBtn = document.getElementById('closeEditModalBtn');
    const editForm = document.getElementById('editAchievementForm');

    // При клике на "редактировать"
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const card = this.closest('.achievement-card');
            const name = card.querySelector('h3').innerText.trim();
            const description = card.querySelector('p').innerText.trim();
            const coins = card.querySelector('.coins').innerText.replace('+', '').trim();
            const imageSrc = card.querySelector('.achievement-img').src;
            const requiredCount = card.getAttribute('data-required-count');
            // Получаем ID через data-id
            const achievementId = this.dataset.id;
        
            // Заполняем форму
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_intexcoin').value = coins;
            document.getElementById('edit_required_count').value = requiredCount;

            // Обновляем preview изображения
            const preview = document.getElementById('editImagePreview');
            preview.style.backgroundImage = `url(${imageSrc})`;
            preview.style.backgroundSize = 'auto 90%';
            preview.style.backgroundRepeat = 'no-repeat';
            preview.style.backgroundPosition = 'center';
            preview.style.opacity = '0.5';
            if (preview.querySelector('.plus-icon')) {
                preview.querySelector('.plus-icon').remove();
            }

            // Устанавливаем action формы
            editForm.setAttribute('action', '/admin/achievements/' + achievementId);

            // Открываем модалку
            editModal.style.display = 'block';
        });
    });

    // Закрытие по крестику
    closeEditModalBtn.addEventListener('click', function () {
        closeModal('editAchievementModal');
    });

    // Закрытие по клику вне окна
    window.addEventListener('click', function (event) {
        if (event.target === editModal) {
            closeModal('editAchievementModal');
        }
    });

    // Предпросмотр нового изображения при выборе файла
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
});