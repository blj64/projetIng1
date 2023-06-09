<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/challenges.css">
    <title>Data battles</title>
</head>
<body>
    <?php require_once ($_SERVER['DOCUMENT_ROOT'].'/php/header.php'); ?>

    <div class="main">
        <div class="center">
            <div class="feed">

                <?php

                if(session_status() == PHP_SESSION_NONE)
                    session_start();

                require_once($_SERVER['DOCUMENT_ROOT'] . '/php/bdd.php');
                if (!is_connected_db())
                    connect_db();

                if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id']))
                {
                    header('Location: /pages/connexion.php');
                    exit(1);
                }

                if (!roleUser($_SESSION['user']['id'], MANAGER))
                {
                    header('Location: /pages/acceuil.php?error=Vous n\'avez pas les droits pour accéder à cette page');
                    exit(1);
                }    
                    
                $dataC = getManagersDataChallenges();
                $events = array();
                foreach ($dataC as $key => $value) {
                    if($value['id'] == $_SESSION['user']['id'])
                        $events[] = $value;
                }

                foreach ($events as $key => $value) 
                {
                    $desc = substr($value['description'], 0, 255);
                    if (strlen($value['description']) > 255)
                        $desc .= '....';
                    
                    echo
                    '<div class="event">
                        <div class="event-img">
                            <img src="'.$value['image'].'" alt="image-event">
                        </div>
                        <div class="event-intel">
                            <h1>'.$value['name'].'</h1>
                            <p>
                            '. $desc .'
                            </p>
                        </div>
                        <div class="bottom-event">
                            <div class="delais">
                                <input type="date" id=deb value="'.$value["startDate"].'" disabled="true">
                                <span>:</span>
                                <input type="date" id=fin value="'.$value["endDate"].'" disabled="true">
                            </div>
                            <a href="challengesPage.php?id='. $value['idDataC'] .'">En savoir plus</a>
                        </div>
                    </div>';
                }
                
                ?>
         

            </div>
        </div>

    </div>

    <?php //require_once ($_SERVER['DOCUMENT_ROOT'].'/php/footer.php'); ?>
</body>
</html>