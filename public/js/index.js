import { fetchUpdateCoin,fetchTrashUser,fetchAddAdmin } from "./fetchToUsers.js";


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
if (button) {
let menu = document.getElementById("modalMenu")
let closebutton = document.getElementById("closeModalMenu")

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
        if (document.querySelector('#search')) {          
        document.querySelector('#search').oninput = function (){
          let val = this.value.trim();
          let items = document.querySelectorAll('.ulUser li')
          if (val != '') {
            items.forEach(function(elem){
              console.log(elem)
              if(elem.innerText.search(val) == -1){
              }else{
                document.querySelector('.ulUser').style.display = 'flex';
                elem.classList.remove('hide');
              }
            })
          }else{
             items.forEach(function(elem){
                document.querySelector('.ulUser').style.display = 'none';
                elem.classList.add('hide');
          })
        }
      }
        }
//меню для аватара 
let buttonAvatar = document.getElementById("addAvatar")
let menuAvatar = document.getElementById("addAvatarMenu")
let closebuttonAvatar = document.getElementById("closeModalMenuAvatar")
if (button != null) {
  
 buttonAvatar.addEventListener('click', function() {
  menuAvatar.style.display = "block"
  buttonAvatar.style.display = "none"
 })
  closebuttonAvatar.addEventListener('click', function() {
  menuAvatar.style.display = "none"
  buttonAvatar.style.display = "block"
 })
}
if(document.querySelector('#formAddAvatar')){
document.querySelector('#formAddAvatar').addEventListener('change', function(e) {  
    var inputs = this.querySelectorAll('input[type=radio]');  
    for (var i = 0; i < inputs.length; i++) {  
        if (e.target === inputs[i]) continue;  
        inputs[i].disabled = true;  
    }  
}); 
}
//всплавающее меню
document.querySelector('.menu-btn').addEventListener('click', function(e) {
  console.log("ok");
  e.preventDefault();
  document.querySelector('.menu').classList.add('menu_active');
    document.querySelector('.wrapper').style.boxShadow = "0 0 0 max(100vh, 100vw) rgba(0, 0, 0, 0.5)"
});
  window.addEventListener('click', function(e) {
  if (!e.target.closest('.menu-btn') && !e.target.closest('.wrapper')) {
    document.querySelector('.wrapper').style.boxShadow = "none"
  document.querySelector('.menu').classList.remove('menu_active');
  }
});
//модалки для страницы с юзерами
document.querySelectorAll('#coinModalOpen').forEach(function(elem){
elem.querySelector('#coinModalImg').addEventListener('click',function(){    
  elem.querySelector('.coinModalMenu').style.display ="block"
    elem.querySelector('.coinModalMenu').style.boxShadow = "0 0 0 max(100vh, 100vw) rgba(0, 0, 0, 0.5)"
    elem.querySelector('.closeCoinModalMenu').addEventListener('click',function(){
  elem.querySelector('.coinModalMenu').style.display ="none"
    elem.querySelector('.coinModalMenu').style.boxShadow = "none"
})
})
})

document.querySelectorAll('#trashModalOpen').forEach(function(elem){
elem.querySelector('#trashModalImg').addEventListener('click',function(){
  elem.querySelector('.trashModalMenu').style.display ="block"
    elem.querySelector('.trashModalMenu').style.boxShadow = "0 0 0 max(100vh, 100vw) rgba(0, 0, 0, 0.5)"
    elem.querySelector('.closeTrashModalmenu').addEventListener('click',function(){
  elem.querySelector('.trashModalMenu').style.display ="none"
    elem.querySelector('.trashModalMenu').style.boxShadow = "none"
})
})
})

document.querySelectorAll('#addAdminModalOpen').forEach(function(elem){
elem.querySelector('#addAdminModalImg').addEventListener('click',function(){
  elem.querySelector('.addAdminModalMenu').style.display ="block"
    elem.querySelector('.addAdminModalMenu').style.boxShadow = "0 0 0 max(100vh, 100vw) rgba(0, 0, 0, 0.5)"
    elem.querySelector('.closeAddAdminMenu').addEventListener('click',function(){
  elem.querySelector('.addAdminModalMenu').style.display ="none"
    elem.querySelector('.addAdminModalMenu').style.boxShadow = "none"
})
})
})

document.querySelectorAll('.coinModalMenu > form').forEach(function(elem){
  elem.addEventListener('submit',function(event){
    event.preventDefault()
      fetchUpdateCoin(elem)
  })
})

document.querySelectorAll('.trashModalMenu').forEach(function(elem){
  elem.querySelector('#formTrashModal').addEventListener('submit',function(event){
    event.preventDefault()
      fetchTrashUser(elem)
       window.addEventListener('click', function(e) {
         if (!e.target.closest('.trashSuccess')) {
          elem.querySelector('.trashSuccess').style.boxShadow = "none"
          elem.querySelector('.trashSuccess').style.display = "none"
          elem.style.display = "none"
          location.reload();
         }
       })
  })
})

document.querySelectorAll('.addAdminModalMenu').forEach(function(elem){
 if(!elem.querySelector('.isAdmin')){
  elem.querySelector('#formAddAdminModal').addEventListener('submit',function(event){
    event.preventDefault()
      fetchAddAdmin(elem)
       window.addEventListener('click', function(e) {
         if (!e.target.closest('.addAdminSuccess')) {
          elem.querySelector('.addAdminSuccess').style.boxShadow = "none"
          elem.querySelector('.addAdminSuccess').style.display = "none"
          elem.style.display = "none"
          location.reload();
         }
      })
  })
}
})
document.querySelector('.menuButtonAdaptive').addEventListener('click', function(e) {
  e.preventDefault();
  document.querySelector('.menuAdaptive').classList.add('menu_activeAdaptive');
  document.querySelector('.menuButtonAdaptive').style.display = "none"
  document.querySelector('.closeMenuButtonAdaptive').style.display = "block"
  document.querySelector('.wrapperAdaptive').style.boxShadow = "0 97px 0 max(95vh, 100vw) rgba(0, 0, 0, 0.3)"
})
  window.addEventListener('click', function(e) {
  if (!e.target.closest('.wrapperAdaptive') && !e.target.closest('.menuButtonAdaptive')) {
      console.log('11')
  document.querySelector('.wrapperAdaptive').style.boxShadow = "none"
  document.querySelector('.closeMenuButtonAdaptive').style.display = "none"
  document.querySelector('.menuButtonAdaptive').style.display = "block"
  document.querySelector('.menuAdaptive').classList.remove('menu_activeAdaptive');
  }
});