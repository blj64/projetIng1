<?php
    if( session_status() != PHP_SESSION_ACTIVE ) session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['group']) || $_SESSION['user']['group'] == NULL) {
        header("Location: /pages/noGroup.php");
        exit();
    }

    require_once $_SERVER["DOCUMENT_ROOT"] . '/php/bdd.php';    
    if( !is_connected_db())
        connect_db();


    $group = getGroupById($_SESSION['user']['group'])[0];
    $groupUser = getStudentsGroup($_SESSION['user']['group']);
    
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/myGroup.css">
    <title>IAPau my group</title>
</head>

<body>
    <?php //require_once $_SERVER["DOCUMENT_ROOT"] . '/php/header.php'; 
    ?>
    <div style="height: 10vh; background-color:blueviolet;">
        <h1>I'm a header</h1>
    </div>
    <div class="main">

        <div class="center">
            <nav class="menu">
                <a href="#Main" class="list active" onclick="changeMenu(this)">Mon équipe</a>
                <a href="#Messagerie" class="list" onclick="changeMenu(this)">Messagerie</a>
                <?php if ($_SESSION['user']['id'] == $group['idLeader']) echo '<a href="#Setting" class="list" onclick="changeMenu(this)">Paramètre</a> '; ?>
                <a href="#Rendu" class="list" onclick="changeMenu(this)">Rendu</a>
            </nav>
            <div class="rest">

                <!-- Mon équipe -->
                <div class="content-box" id="Main">
                    <div class="left-box">
                        <div class="banner-group-name">
                            <h1><?php echo $group['name'] ?></h1>
                        </div>
                        <div class="list-group-name">
                            <fieldset>
                                <legend>My team</legend>
                                
                                <?php 
                                    foreach( $groupUser as $user ) {
                                        echo '<div class="student">';
                                        
                                        if( $user['id'] == $group['idLeader'] )
                                            echo '<img class="leader" src="/asset/icon/crown.ico" alt="chef">';
                                        
                                            $me = '';
                                        if( $user['id'] == $_SESSION['user']['id'] )
                                            $me = ' class="me"';
                                        
                                        echo '<p'. $me .'>' . $user['firstName'] . ' ' . $user['lastName'] . '</p>';
                                        echo '</div>';
                                    }
                                ?>

                            </fieldset>
                        </div>
                    </div>
                    <div class="right-box">
                        <a class="card" href="#LINK TO THE DATA">
                            <div class="filter">
                                <div class="dataC-img">
                                    <div class="dataC-text">
                                        <h1>DATA CHALL NAME</h1>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Messagerie -->
                <div class="content-box" id="Messagerie" style="display: none;">
                    <div class="left-bar">
                        <button onclick="generateFormNewUser()" class="new-message">
                            <div class="student" id="new-msg">
                                <p>Nouveau message</p>
                                <img class="mini-menu" src="/asset/icon/plus.ico" alt="menu">
                            </div>
                        </button>
                        <div class="list-contact">


                            <?php
                                $contacts = getAllUserContacted($_SESSION['user']['id']);
                                foreach ($contacts as $contact) {
                                    echo "<button class='contact active' onclick='changeConversation(".$_SESSION['user']['id'].", ".$contact["id"]."); changeIdSender(".$contact["id"].")'>";
                                        echo "<div class='contact-img'>";
                                            echo "<img src='/asset/icon/crown.ico' alt='PP'>";
                                        echo "</div>";
                                        echo "<div class='contact-text'>";
                                            echo "<p>".$contact["firstName"]." ".$contact["lastName"]."</p>";                                
                                            echo "<span id='online'>online</span>";
                                        echo "</div>";
                                    echo "</button>";
                                }
                                
                            ?>
                            


                        </div>
                    </div>

                    <div class="messagerie">
                        <div class="history" id="messagerie-container">
                            
                        </div>
                        <div class="entry">
                            <div class="entry-bar">
                                

                                <div id="message">
                                    <form id="msg-new-form">
                                        <div>
                                            <input name="msg" placeholder="message" type="text">
                                            <!-- REMPLACER LA VALUE PAR L ID DE LA PERSONNE A QUI ON PARLE -->
                                            <input id="user-contacted" type="hidden" name="sender" value="2">
                                            <input type="hidden" name="receiver" value="<?php echo $_SESSION['user']['id']?>">

                                        </div>
                                        <div>
                                            <button type="button" onclick="loadSendMsg()">Envoyer</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Paramètre -->
                <div class="content-box" id="Setting" style="display: none;">
                </div>


                <!-- Rendu -->
                <div class="content-box" id="Rendu" style="display:none">
                    <div class="left-box">
                        <div class="rendu-box">
                            <h1>Mettez votre fichier python ici ↓↓</h1>
                            <form class="box" method="post" action="" enctype="multipart/form-data">
                                <div class="drop-zone">
                                    <span class="drop-zone__prompt">Drop file here or <span id="click">click</span> to upload</span>
                                    <input type="file" name="myFile" class="drop-zone__input">
                                </div>
                                <div class="box__uploading">Uploading…</div>
                                <div class="box__success">Upload success!</div>
                                <div class="box__error">Upload error! <span id="add_error"></span>.</div>
                            </form>
                            <div class="send-data">
                                <button id=send_button type="submit">Générer les statistiques</button>
                            </div>
                        </div>
                        <div class="stats-box">

                        </div>
                    </div>

                    <div class="right-box">

                    </div>
                </div>

            </div>
        </div>

    </div>

    <div style="height: 10vh; background-color:red;padding-top:0px;">
        <h1>I'm a footer</h1>
    </div>
    <?php //require_once $_SERVER["DOCUMENT_ROOT"] . '/php/footer.php'; 
    ?>
</body>
<script src="/js/myGroup.js"></script>
<script src="/js/chatBox.js"></script>
<script>setInterval(changeConversation, 2000, <?php echo $idReceiver?>);</script>


</html>

<!-- author : DURAND Nicolas -->
<!-- date : 2021-05-05 -->
<!-- mail : durandnico@cy-tech.fr -->