export function fetchUpdateCoin(elem){
 fetch(`updateCoins/${elem.dataset.id}`, {
                method: "PUT",
                headers: {
                    'content-type': "application/json",
                    "x-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({
                    balance: elem.querySelector('#balance').value // Исправлено: используем переменную quantity
                })
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                  console.log('1111')
                  elem.querySelector('.buttonsModalMenu > button').textContent ='СОХРАНЕНО'
                } else {
                    alert("Error updating item");
                }
            })
            .catch((e) => console.error('Error:',e));
}
export function fetchTrashUser(elem){
     fetch(`remove/${elem.querySelector("#formTrashModal").dataset.id}`, {
                method: "POST",
                headers: {
                    'content-type': "application/json",
                    "x-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                  console.log('1111')
                  elem.querySelector('.trashSuccess').style.display="flex"
                  elem.querySelector('.trashSuccess').style.boxShadow = "0 0 0 max(100vh, 100vw) rgba(0, 0, 0, 0.5)"
                } else {
                    alert("Error updating item");
                }
            })
            .catch((e) => console.error('Error:',e));
}
export function fetchAddAdmin(elem){
     fetch(`../admin/newAdmin/${elem.querySelector("#formAddAdminModal").dataset.id}`, {
                method: "PUT",
                headers: {
                    'content-type': "application/json",
                    "x-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                  console.log('1111')
                  elem.querySelector('.addAdminSuccess').style.display="flex"
                  elem.querySelector('.addAdminSuccess').style.boxShadow = "0 0 0 max(100vh, 100vw) rgba(0, 0, 0, 0.5)"
                } else {
                    alert("Error updating item");
                }
            })
            .catch((e) => console.error('Error:',e));
}