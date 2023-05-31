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
    <style>
        canvas{
            display: block;
            box-sizing: border-box;
            height: 250px;
            width: 250px;
        }

        .chart-container{
            padding: 15px;
        }

    </style>
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
                            <form class="box" id="yourForm" enctype="multipart/form-data">
                                <div class="drop-zone">
                                    <span class="drop-zone__prompt">Drop file here or <span id="click">click</span> to upload</span>
                                    <label for="yourFile"></label>
                                    <input type="file" id="yourFile" name="yourFile" class="drop-zone__input" required>
                                </div>
                                <div class="box__uploading">Uploading…</div>
                                <div class="box__success">Upload success!</div>
                                <div class="box__error">Upload error! <span id="add_error"></span>.</div>
                                <div class="send-data">
                                    <button id="send_button" type="submit">Charger le fichier</button>
                                </div>
                            </form>
                            <div class="send-data">
                                <button>Sauvegarder les données</button>
                            </div>
                            <div class="send-data">
<!--                                <button onclick="charger()">Charger les données précédentes</button>-->
                            </div>

                        </div>
                        <div class="stats-box">
                            <div class="chart-container">
                                <canvas id="barCanvas" aria-label="chart" role="img"></canvas>
                            </div>
                        </div>
                    </div>



                    <div class="right-box">

                        <div class="send-data">
                            <button id="send_button" onclick="afficher()">Générer les graphiques</button>
                            <div id="result" style="display: none"></div>

                        </div>

                        <div class="chart-container">
                            <canvas id="barCanvas2" aria-label="chart" role="img"></canvas>
                            <canvas id="barCanvas3" aria-label="chart" role="img"></canvas>
                        </div>


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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/js/chatBox.js"></script>
<script>

    // function charger(){
    //     if(/* Prendre la valeur du JSON dans la BDD et regarder si != null */){
    //         //res = Récupérer la chaine de caractère de la BDD
    //         document.getElementById("result").textContent = res;
    //         afficher();
    //     }
    // }

    document.getElementById("yourForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Annuler le comportement par défaut du formulaire


        var formData = new FormData();
        var fileInput = document.getElementById("yourFile");

        // Vérifier si un fichier a été sélectionné
        if (fileInput.files.length > 0) {
            alert("Fichier correctement chargé");
            var file = fileInput.files[0];
            formData.append("myFile", file);

            // Effectuer une requête POST vers votre serveur Java avec le fichier
            fetch("http://localhost:8081/endpoint", {
                method: "POST",
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    // Mettre à jour la div avec la réponse du serveur
                    document.getElementById("result").textContent = data;
                    console.log("TEST");
                })
                .catch(error => {
                    console.error("Erreur:", error);
                });
        } else {
            console.error("Aucun fichier sélectionné.");
        }
    });


    function afficher(){
        res = document.getElementById("result").textContent;
        if(res != null) {
            data = JSON.parse(res);
            console.log(data["fonctions"]["tailles_fonctions"]);

            var taillesFonctions = data.fonctions.tailles_fonctions[0];

            var keys = Object.keys(taillesFonctions);
            var values = Object.values(taillesFonctions);

            const barCanvas = document.getElementById("barCanvas");

            const barChart = new Chart(barCanvas, {
                type: "bar",
                data: {
                    labels: keys,
                    datasets: [{
                        label: "Nombre de lignes",
                        data: values,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(255, 159, 64, 0.5)',
                            'rgba(255, 205, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Tailles de vos différentes fonctions',
                            padding: {
                                top: 10,
                                bottom: 30
                            }
                        }
                    }
                }
            })

            var keys2 = Object.keys(data);
            let index = keys2.indexOf("fonctions");
            keys2.splice(index, 1);
            var values2 = Object.values(data);
            values2.splice(index, 1);

            const barCanvas2 = document.getElementById("barCanvas2");

            const barChart2 = new Chart(barCanvas2, {
                type: "pie",
                data: {
                    labels: keys2,
                    datasets: [{
                        data: values2,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(255, 159, 64, 0.5)',
                            'rgba(255, 205, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                        ],
                        hoverOffset: 12
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Nombre de lignes au sein de votre code',
                            padding: {
                                top: 10,
                                bottom: 30
                            }
                        }
                    }
                }
            })





            var fonctions = data.fonctions;

            var keys3 = Object.keys(fonctions);
            var values3 = Object.values(fonctions);
            keys3.splice(0,1);
            keys3.splice(3,1);
            values3.splice(0,1);
            values3.splice(3,1);


            const barCanvas3 = document.getElementById("barCanvas3");

            const barChart3 = new Chart(barCanvas3, {
                type: "pie",
                data: {
                    labels: keys3,
                    datasets: [{
                        data: values3,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                        ],
                        hoverOffset: 12
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Différentes statistiques concernant vos fonctions',
                            padding: {
                                top: 10,
                                bottom: 30
                            }
                        }
                    }
                }
            })




        }
    }


</script>
</html>

<!-- author : DURAND Nicolas -->
<!-- date : 2021-05-05 -->
<!-- mail : durandnico@cy-tech.fr -->