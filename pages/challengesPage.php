<?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])){
        header('Location: pages/index.php?error=notConnected');
        exit();
    }

    if(!isset($_GET['id'])){
        header('Location: /pages/index.php?error=missingId');
        exit();
    }

    require_once('../php/bdd.php');

    if (!is_connected_db())
        connect_db();

    $challenge = getDataChallengeById($_GET['id']);
    
    if(!$challenge){
        header('Location: /pages/index.php?error=challengeNotFound');
        exit();
    }

    $challenge = $challenge[0];
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="stylesheet" href="../css/accueil.css">
		<link rel="stylesheet" href="../css/challengesPage.css">
		<link rel="stylesheet" href="../css/join.css">
        <link rel="stylesheet" href="../css/footer.css">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Accueil</title>
	</head>
	<body>
        <div id="part1">
            <?php require('../php/header.php'); ?>
        </div>
        <div id ="part2">
            <div id="dataPage">
                <div id="Z0DP">
                    <p id=main-title <?php if(roleUser($_SESSION['user']['id'], ADMIN) || roleUser($_SESSION['user']['id'], MANAGER)) echo 'contenteditable="true"'; ?> ><?php echo $challenge['name']; ?><p>
                        <div id="formeZ01">
                            </div>
                            <div id="formeZ02">
                                </div>
                                <div id="formeZ03">
                                    </div>
                                </div>
                                <div id="Z1DP">
                                    <div id="img-dataPage" class="imgSpaceBetween">
                                        <img width="400px" src="<?php echo $challenge['image']; ?>" alt="" class="imgSpaceBetween">
                                    </div>
                                    <div id="info-dataPage"> 
                                        <div id="archive">
                                            <a href="...">Archives  Data Challenges</a>
                        </div>
                        <div id="date">
                            <input id=startDate type="date" <?php if(!roleUser($_SESSION['user']['id'], ADMIN) && !roleUser($_SESSION['user']['id'], MANAGER)) echo 'disabled'; ?> value="<?php echo $challenge['startDate'] ?>">
                            <input id=endDate type="date" <?php if(!roleUser($_SESSION['user']['id'], ADMIN) && !roleUser($_SESSION['user']['id'], MANAGER)) echo 'disabled'; ?> value="<?php echo $challenge['endDate'] ?>"> 
                        </div>   
                    </div>    
                </div>
                <div class="main-desc">
                    <p id=main-desc <?php if(roleUser($_SESSION['user']['id'], ADMIN) || roleUser($_SESSION['user']['id'], MANAGER)) echo 'contenteditable="true"'; ?>><?php echo $challenge['description']; ?></p>
                    <h2>Les sujets disponibles</h2>
                    
                    <?php
                    
                    $count = 1;
                    $op = ""; 
                    if(roleUser($_SESSION['user']['id'], ADMIN) || roleUser($_SESSION['user']['id'], MANAGER)) 
                    $op = " contenteditable='true' ";
                    
                    foreach(getSubjectsByIdChallenge($_GET['id']) as $subject)
                    {
                        echo '<div class="subject">';
                        echo '<h3 '.$op.' id=subject-desc-'.$count.'>'.$subject['name'].'</h3>';
                        echo '<p '.$op.' id=subject-desc-'.$count++.'>'.$subject['description'].'</p>';
                        echo '</div>';
                    }
                    ?>

</div>

<div class="inscription">
    <?php 
                        if(roleUser($_SESSION['user']['id'], ADMIN) || roleUser($_SESSION['user']['id'], MANAGER))
                        {
                            if(roleUser($_SESSION['user']['id'], ADMIN) ||  getHandlerByIdManager($_SESSION['user']['id'])[0]['idDataC'] == $challenge['idDataC'])
                                echo '<button id="edit" onclick="Sauvegarder('.$challenge['idDataC'].')">Sauvegarder les modifications</button>';
                        }        
                        else
                        echo '<button onclick="inscrire('.$_GET['id'].')" > S\'inscrire </button>';
                        ?>
                </div>
            </div>
        </div>
		<div id = "part6">
            <?php require('../php/join.php'); ?>
		</div>
		<div id="part7">
            <?php require('../php/footer.php'); ?>
		</div>	
	</body>
    <script src="/js/challenge.js"></script>
</html>