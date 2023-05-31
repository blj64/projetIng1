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
                    <p><?php echo $challenge['name']; ?><p>
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
                            <input type="date" disabled value="<?php echo $challenge['startDate'] ?>">
                            <input type="date" disabled value="<?php echo $challenge['endDate'] ?>"> 
                        </div>   
                    </div>    
                </div>
                <div class="main-desc">
                    <p><?php echo $challenge['description']; ?></p>
                    <h2>Les sujets disponibles</h2>
                    
                    <?php
                    
                    foreach(getSubjectsByIdChallenge($_GET['id']) as $subject)
                    {
                        echo '<div class="subject">';
                        echo '<h3>'.$subject['name'].'</h3>';
                        echo '<p>'.$subject['description'].'</p>';
                        echo '</div>';
                    }
                    ?>

                </div>

                <div class="inscription">
                    <button>S'inscrire</button>
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
</html