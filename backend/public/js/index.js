
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
