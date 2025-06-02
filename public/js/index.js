
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
if (button != null) {
  
 button.addEventListener('click', function() {
  menu.style.display = "flex"
  button.style.display = "none"
  menu.style.boxShadow = "0 0 0 max(100vh, 100vw) rgba(0, 0, 0, 0.5)"
 })
  closebutton.addEventListener('click', function() {
  menu.style.display = "none"
  button.style.display = "block"
 })

}
     function toggleDateTimeFields() {
            const typeSelect = document.getElementById('type');
            const dateTimeFields = document.getElementById('dateTimeFields');
            if (typeSelect != null && dateTimeFields != null) {
              
            // Если выбран Offline — показываем поля
            if (typeSelect.value === 'Offline') {
                dateTimeFields.style.display = 'block';
            } else { // Иначе скрываем (Online)
                dateTimeFields.style.display = 'none';
            }
            }
        }

        // При загрузке страницы сразу проверяем выбранный тип
        document.addEventListener('DOMContentLoaded', function() {
            toggleDateTimeFields();
        });

        //live search
        document.querySelector('#search').oninput = function (){
          let val = this.value.trim();
          let items = document.querySelectorAll('.ulUser li')
          if (val != '') {
            items.forEach(function(elem){
              console.log(elem)
              if(elem.innerText.search(val) == -1){
              }else{
                elem.classList.remove('hide');
              }
            })
          }else{
             items.forEach(function(elem){
                elem.classList.add('hide');
          })
        }
      }
