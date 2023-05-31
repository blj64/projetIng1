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
        console.log(idSender);  
    }

    var activeElements = document.querySelectorAll(".active");

    
}

function generateFormNewUser() {
    // Create the form element
  var form = document.createElement('form');
  form.setAttribute('id', 'contact-new-user-form');

  // Add input elements to the form
  var input1 = document.createElement('input');
  input1.setAttribute('type', 'text');
  input1.setAttribute('class', 'sub-msg');

  input1.setAttribute('name', 'newUser');
  form.appendChild(input1);

  var input2 = document.createElement('input');
  input2.setAttribute('type', 'text');
  input2.setAttribute('class', 'sub-msg');

  input2.setAttribute('name', 'message');

  form.appendChild(input2);

  // Add a submit button to the form
  var submitButton = document.createElement('button');
  submitButton.setAttribute('type', 'button');
  submitButton.setAttribute('class', 'sub-msg');
  submitButton.setAttribute('onclick', 'contactNewUser()');
  form.appendChild(submitButton);

  // Replace the content of messagerie-container with the form
  var container = document.getElementById('messagerie-container');
  container.innerHTML = '';
  container.appendChild(form);
}
