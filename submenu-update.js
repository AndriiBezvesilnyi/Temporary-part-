document.addEventListener("DOMContentLoaded", function () {

    let butUpdate = document.getElementById('publishing-action');
    if(butUpdate) {
        butUpdate.addEventListener('click', (e) => {
         
            const data = new FormData();
            data.append('action', 'uv_submenu_update');
            data.append('updata', 'update');
            console.log(data);
            fetch(ajaxurl, {
              method: "POST",
              credentials: 'same-origin',
              body: data
            })
            .then(response => {
              if (!response.ok) {
                throw new Error('Network response was not ok');
              }
    
              return response.json();
            })
            .then(data => {

              
            })
            .catch(error => {
              console.error('Error getting data:', error);
            });
    


        });
    }
    
});