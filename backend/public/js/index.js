
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}


window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

document.querySelectorAll('.dropdown-btn').forEach(button => {
  button.addEventListener('click', function() {
    const container = this.closest('.dropdown-container');
    container.classList.toggle('active');
  });
});

// Закрывать при клике вне списка
document.addEventListener('click', function(e) {
  if (!e.target.closest('.dropdown-container')) {
    document.querySelectorAll('.dropdown-container').forEach(container => {
      container.classList.remove('active');
    });
  }
});

//модальное окно для ЛК

let button = document.getElementById("PC")
let menu = document.getElementById("modalMenu")
let closebutton = document.getElementById("closeModalMenu")

 button.addEventListener('click', function() {
  menu.style.display = "flex"
  button.style.display = "none"
 })
  closebutton.addEventListener('click', function() {
  menu.style.display = "none"
  button.style.display = "block"
 })

         function toggleDateTimeFields() {
            const typeSelect = document.getElementById('type');
            const dateTimeFields = document.getElementById('dateTimeFields');
            
            if (typeSelect.value === 'Online') {
                dateTimeFields.style.display = 'none';
            } else {
                dateTimeFields.style.display = 'block';
            }
        }

        // Вызываем функцию при загрузке страницы, чтобы установить начальное состояние
        document.addEventListener('DOMContentLoaded', function() {
            toggleDateTimeFields();
        });

