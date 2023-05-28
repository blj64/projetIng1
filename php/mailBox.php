<?php
require_once("bdd.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Website</title>
</head>
<body>
    <div id="boxmail-div">
        <?php 
        //Change $idReceiver to the id of the current user
            $idReceiver = 1; 
        ?>
        <section id="user-conv">
            <button class="" id="new-chat">+</button>
            <?php
                $senders = getAllUserContacted($idReceiver);
                foreach($senders as $user) {
                    echo "<button onclick='changeConversation(".$user["id"].")'>";
                    echo $user["firstName"];
                    echo "</button><br>";
                }
            ?>
        </section>
        <section id="boxmail">
            <div id="msg-person-div">
                <h2>Personne</h2>
            </div>
            <div id="msg-container-div">
                
            </div>
            <div id="msg-new-div">
                <form id="msg-new-form">
                    <input name="msg" placeholder="message" type="text">
                    <!-- REMPLACER LA VALUE PAR L ID DE LA PERSONNE A QUI ON PARLE -->
                    <input type="hidden" name="sender" value="2">
                    <input type="hidden" name="receiver" value="<?php echo $idReceiver?>">

                    <button type="button" onclick="loadSendMsg()">Click here</button>
                </form>
            </div>
        </section>
    </div>

    <script>
        
        function loadSendMsg() {
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onload = function() {
                const response = this.responseText;
                const msgContainer = document.getElementById("msg-container-div");
                const newMsg = document.createElement("span");
                newMsg.innerHTML = response;
                msgContainer.appendChild(newMsg);
            }

            // Get the form data
            const form = document.getElementById("msg-new-form");
            const formData = new FormData(form);

            xmlhttp.open("POST", "sendMsg.php");
            xmlhttp.send(formData);
        }

        function changeConversation(id) {
            const idSender = 1; // Replace with the actual sender ID
            const idReceiver = id;

            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = xhr.responseText;
                    document.getElementById("msg-container-div").innerHTML = response;
                }
            };
            console.log("loadMessage.php?idReceiver=" + idReceiver + "&idSender=" + idSender);
            xhr.open("GET", "loadMessage.php?idReceiver=" + idReceiver + "&idSender=" + idSender, true);
            xhr.send();
        
        }

        // Prevent default form submission behavior
        const form = document.getElementById("msg-new-form");
        form.addEventListener("submit", function(event) {
            event.preventDefault();
        });



    </script>
   

</body>
</html>


