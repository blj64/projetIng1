
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
                    <button class="" id="new-chat">
                        +
                    </button>
                    <button id="peio-chat">peio</button>
                </section>
                <section id="boxmail">
                    <div id="msg-person-div">
                        <h2>Personne</h2>
                    </div>
                    <div id="msg-container-div">

                    </div>
                    <div id="msg-new-div">
                        <form action="sendMsg.php" method="POST">
                            <input name="msg" placeholder="message" type="text">
                            <input type="hidden" name="datetime" value="<?php echo date("h:i:sa"); ?>" />
                            <input type="hidden" name="sender" value="1">
                            <input type="hidden" name="receiver" value="2">

                            <input type="submit" value="send">
                            
                        </form>
                    </div>
                </section>  
            </div>  
        </body>
