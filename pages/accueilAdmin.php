
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="stylesheet" href="../css/accueil.css">
		<link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/underHeader.css">
        <link rel="stylesheet" href="../css/footer.css">
        
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Accueil</title>
	</head>
	<body>
        <?php 
            include('../php/bdd.php');
            
        ?>
		<div id="part1">
			<?php include('../php/header.php'); ?>
		</div>
        <div id="part2">
            <?php include('../php/underHeader.php'); ?>
		</div>
        <div id="part3">
            <div id ="card" class="card-box">

                <?php
                if(roleUser($_SESSION['user']['id'], STUDENT)==1){
                echo('<a href="/pages/myGroup.php" id="Team" class="card">
                    <div class="filter">
                        <div class="card-img">
                            <h1>Mon équipe</h1>
                        </div>
                    </div>
                </a>


                <a href="/pages/dataC.php" id="DataC" class="card">
                    <div class="filter">
                            <div class="card-img">
                            <h1>Les challenges</h1>
                        </div>
                    </div>
                </a>

                
                <a href="/pages/profil.php" id="profile" class="card">
                    <div class="filter">
                        <div class="card-img">
                            <h1>Mon profil</h1>
                        </div>
                    </div>
                </a>');
                }else if(roleUser($_SESSION['user']['id'], ADMIN)==1){
                    echo('<a href="/pages/myGroup.php" id="Team" class="card">
                    <div class="filter">
                        <div class="card-img">
                            <h1>Gestion des gestionnaires</h1>
                        </div>
                    </div>
                </a>


                <a href="/pages/dataC.php" id="DataC" class="card">
                    <div class="filter">
                            <div class="card-img">
                            <h1>Gestion des challenges</h1>
                        </div>
                    </div>
                </a>

                
                <a href="/pages/profil.php" id="profile" class="card">
                    <div class="filter">
                        <div class="card-img">
                            <h1>Mon profil</h1>
                        </div>
                    </div>
                </a>');
                }else if(roleUser($_SESSION['user']['id'], MANAGER)==1){
                    echo('<a href="/pages/myGroup.php" id="Team" class="card">
                    <div class="filter">
                        <div class="card-img">
                            <h1>Gérer les challenges</h1>
                        </div>
                    </div>
                </a>


                <a href="/pages/dataC.php" id="DataC" class="card">
                    <div class="filter">
                            <div class="card-img">
                            <h1>Gérer les équipes</h1>
                        </div>
                    </div>
                </a>

                
                <a href="/pages/profil.php" id="profile" class="card">
                    <div class="filter">
                        <div class="card-img">
                            <h1>Mon profil</h1>
                        </div>
                    </div>
                </a>');
                }
                ?>
            </div>
		</div>
		
		<div id="part5">
			<?php require('../php/footer.php'); ?>
		</div>
	
	
		
	
	
	
	</body>
</html