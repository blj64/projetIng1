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
        <section id="user-conv">
            <button class="" id="new-chat">+</button>
            <button id="peio-chat">peio</button>
        </section>
        <section id="boxmail">
            <div id="msg-person-div">
                <h2>Personne</h2>
            </div>
            <div id="msg-container-div">
                <?php
                $messages = getAllMessageFromUser(2);
                foreach ($messages as $message) {
                    foreach ($message as $column => $value) {
                        echo "<span>" . $column . ": " . $value . "</span>";
                    }
                    echo "<br>";
                }
                ?>
            </div>
            <div id="msg-new-div">
                <form id="msg-new-form">
                    <input name="msg" placeholder="message" type="text">
                    <input type="hidden" name="datetime" value="<?php echo date("h:i:sa"); ?>">
                    <input type="hidden" name="sender" value="1">
                    <input type="hidden" name="receiver" value="2">

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

        // Prevent default form submission behavior
        const form = document.getElementById("msg-new-form");
        form.addEventListener("submit", function(event) {
            event.preventDefault();
        });
    </script>
</body>
</html>