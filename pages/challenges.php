<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/challenges.css">
    <link rel="stylesheet" href="../css/footer.css">
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

                $dataC = getAllDataCStarted();
                $isAdmin = roleUser($_SESSION['user']['id'],ADMIN);

                foreach ($dataC as $key => $value) 
                {
                    $desc = substr($value['description'], 0, 255);
                    if (strlen($value['description']) > 255)
                        $desc .= '....';
                    
                    echo
                    '<div class="event">';

                    if( $isAdmin )
                        echo '<button class="delete" onclick="deleteDataC('.$value['idDataC'].')">X</button>';
                    
                    echo '<div class="event-img" id="'.$value['idDataC'].'">
                            <img src="'.$value['image'].'" alt="image-event">
                        </div>
                        <div class="event-intel">
                            <h1>'.$value['name'].'</h1>
                            <p>
                            '. $desc .'
                            </p>
                        </div>
                        <div class="bottom-event">';
                        
                        if ($isAdmin)
                            echo '<span class="show-id">Id du challenge : ' . $value['idDataC'] . '</span>';

                        echo'
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
                <script src="/js/challenge.js"></script>
</body>
</html>