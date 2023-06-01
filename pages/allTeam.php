<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/allTeam.css">
    <link rel="stylesheet" href="/css/gestionUser.css">
    <title>Les équipes</title>
</head>

<body>

    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . '/php/bdd.php');

    if (!is_connected_db())
        connect_db();

    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id']))
        header('Location: /pages/connexion.php');

    if (!roleUser($_SESSION['user']['id'], MANAGER))
        header('Location: /pages/acceuil.php?error=Vous n\'avez pas les droits pour accéder à cette page');

    $tmp = getManagersDataChallenges();
    $res = null;
    foreach ($tmp as $key => $value) {
        if ($value['id'] == $_SESSION['user']['id'])
            $res = $value;
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . '/php/header.php');
    ?>

    <div class="main">

        <div class="center">
            <?php
            if ($res == null) {
                echo "<h1>Vous n'avez pas de data challenge</h1>";
                exit(1);
            }
            ?>

            <div class="dataC">
                <h1>
                    <?php echo $res['name'] ?>
                </h1>
                <input type="hidden" name="idDataC" id=idDataC value="<?php echo $res['idDataC'] ?>">
                <div onclick="location.href='challengesPage.php?id=<?php echo $res['idDataC'];?>'" class="event-img" style="background-image: url('<?php echo $res['image'] ?>');"></div>

                <div class="date">
                    <input type="date" name="" id="" disabled value="<?php echo $res['startDate'] ?>">
                    <input type="date" name="" id="" disabled value="<?php echo $res['endDate'] ?>">
                </div>
            </div>


            <div class="send_form">
                <p>Envoyer un form à toutes les équipes</p>
                <div>
                    <input type="text" name=formulaire id=url>
                    <button onclick="send_form()">Envoyer</button>
                </div>
                <div style="margin-top: 15px;">
                    <p>de :</p>
                    <input type="date" name="startD" id="startD">
                    <p>à :</p>
                    <input type="date" name="endD" id="endD">
                </div>
            </div>

            <?php

            $resquest = "SELECT * FROM `Group` WHERE idDataC = " . $res['idDataC'];
            try {
                $teams = request_db(DB_RETRIEVE, $resquest);
            } catch (Exception $e) {
                echo $e->getMessage();
                exit(1);
            }


            foreach ($teams as $key => $value) {
                $resquest = "SELECT COUNT(*) FROM `In` WHERE idGroup = " . $value['id'];
                try {
                    $nb = request_db(DB_RETRIEVE, $resquest);
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit(1);
                }
                $nb = $nb[0]['COUNT(*)'];

                $request = "SELECT `json` FROM `Student` WHERE idUser = " . $value['idLeader'];
                try {
                    $json = request_db(DB_RETRIEVE, $request);
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit(1);
                }

                $res = "";
                if ($json[0]['json'] == null)
                    $res = "non-";


                echo "<div class='team'>
                        <div>
                            <p>
                                <span id=bold>" . $value['name'] . "</span>
                            </p>
                        </div>
                        <div class='member'>
                            <img id=ntm src='/asset/icon/member.png' alt='membre'>
                            <p>: " . $nb . "</p>
                        </div>
                        
                        <div>
                            <p id=".$res."rendu>" .$res ."rendu</p>
                        </div>

                        <a href='gestionTeam.php?idE=" . $value['id'] . "'>details ici</a>
                    </div>";
            }
            ?>
        </div>

    </div>
    <?php require '../php/footer.php' ?>
</body>
<script src="/js/allTeam.js"></script>
</html>