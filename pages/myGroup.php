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
    <?php //require_once $_SERVER["DOCUMENT_ROOT"] . '/php/header.php'; ?>
    <div style="height: 10vh; background-color:blueviolet;"><h1>I'm a header</h1></div>
    <div class="main">

        <div class="center">
            <nav class="menu">
                    <a href="#Main" class="list" onclick="changeMenu(this)">Mon équipe</a>
                    <a href="#Messagerie" class="list active" onclick="changeMenu(this)">Messagerie</a>
                    <a href="#Setting" class="list" onclick="changeMenu(this)">Paramètre</a>
                </nav>
            <div class="rest">

                <!-- Mon équipe -->
                <div class="content-box" id="Main" style="display: none;">
                    <div class="left-box">
                        <div class="banner-group-name">
                            <h1>Nom du groupe</h1>
                        </div>
                        <div class="list-group-name">
                            <fieldset>
                                <legend>My team</legend>
                                    
                                <div class="student">
                                    <img  class="leader" src="/asset/icon/crown.ico" alt="chef">
                                    <p class="me">Nicolas Durand</p>
                                </div>

                                <div class="student">
                                    <p> Lucas Fernandes </p>
                                    <!--<img class="mini-menu" src="/asset/icon/menu.ico" alt="menu"> -->
                                </div>

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
                <div class="content-box" id="Messagerie">
                    <div class="left-bar">
                        <div class="new-message">
                            <div class="student" id="new-msg">
                                <p>Nouveau message</p>
                                <img class="mini-menu" src="/asset/icon/plus.ico" alt="menu">
                            </div>
                        </div>
                        <div class="list-contact">

                        </div>
                    </div>

                    <div class="messagerie">
                        <div class="history">

                        </div>
                        <div class="entry">

                        </div>
                    </div>
                </div>

                <!-- Paramètre -->
                <div class="content-box" id="Setting" style="display: none;">

                </div>


            </div>
        </div>
        
    </div>
    
    <div style="height: 10vh; background-color:red;padding-top:0px;"><h1>I'm a footer</h1></div>
    <?php //require_once $_SERVER["DOCUMENT_ROOT"] . '/php/footer.php'; ?>
</body>
<script src="/js/myGroup.js"></script>
</html>

<!-- author : DURAND Nicolas -->
<!-- date : 2021-05-05 -->
<!-- mail : durandnico@cy-tech.fr -->