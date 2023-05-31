function changeConversation(idReceiver, idSender) {

    

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = xhr.responseText;
            document.getElementById("messagerie-container").innerHTML = response;
        }
    };
    xhr.open("GET", "/php/loadMessage.php?idReceiver=" + idReceiver + "&idSender=" + idSender, true);
    xhr.send();
        
    
}

function loadSendMsg() {
    const xmlhttp = new XMLHttpRequest();
            xmlhttp.onload = function() {
                const response = this.responseText;
                const msgContainer = document.getElementById("messagerie-container");
                const newMsg = document.createElement("div");
                newMsg.setAttribute("class", "msg right");
                newMsg.innerHTML = response;
                msgContainer.appendChild(newMsg);
                document.getElementById('msg-new-form').reset();
            }

            // Get the form data
            const form = document.getElementById("msg-new-form");
            const formData = new FormData(form);

            xmlhttp.open("POST", "/php/sendMsg.php");
            xmlhttp.send(formData);
}


function changeIdSender(idSender) {
    var inputElement = document.getElementById("user-contacted");

    // Vérification si l'élément existe
    if (inputElement) {
    // Définition de la nouvelle valeur
        inputElement.value = idSender;
    }

    var activeElements = document.querySelectorAll(".active");

    
}

function generateFormNewUser() {
    fetch('/php/contactNewUser.php')
    .then(function(response) {
      return response.text();
    })
    .then(function(data) {
      document.getElementById('messagerie-container').innerHTML = data;
      const searchInput = document.getElementById('user-search-input');
    
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value;

            const xhr = new XMLHttpRequest();  
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    // Process and display the suggestions
                    console.log(data);
                }
            };

            xhr.open('GET', `/php/contactNewUser.php?searchTerm=${searchTerm}`, true);
            xhr.send();
        });
    })
    .catch(function(error) {
      console.error('Error:', error);
    });
    

      
}

function contactNewUser() {
    changeIdSender(6);
    const xmlhttp = new XMLHttpRequest();
            xmlhttp.onload = function() {
                const response = this.responseText;
                const msgContainer = document.getElementById("messagerie-container");
                const newMsg = document.createElement("div");
                newMsg.setAttribute("class", "msg right");
                newMsg.innerHTML = response;
                msgContainer.appendChild(newMsg);
                
            }

            // Get the form data
            const form = document.getElementById("contact-new-user-form");
            const formData = new FormData(form);
            console.log(formData);

            xmlhttp.open("POST", "/php/sendMsg.php");
            xmlhttp.send(formData);

        }



    
