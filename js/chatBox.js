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
        const newMsg = document.createElement("span");
        newMsg.innerHTML = response;
        msgContainer.appendChild(newMsg);
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
        console.log(idSender);  
    }
}
