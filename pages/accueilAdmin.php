
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
        <link rel="stylesheet" href="../css/stripmid.css">
        <link rel="stylesheet" href="../css/footer.css">
        
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Accueil</title>
	</head>
	<body>
		<div id="part1">
			<?php include('../php/header.php'); ?>
		</div>
        <div id="part2">
            <?php include('../php/underHeader.php'); ?>
		</div>
        <div id="part3">
            <div id ="card" class="card-box">

                <a href="/pages/myGroup.php" id="Team" class="card">
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

                
                <a href="/pages/myGroup.php" id="profile" class="card">
                    <div class="filter">
                        <div class="card-img">
                            <h1>Mon profil</h1>
                        </div>
                    </div>
                </a>

            </div>
		</div>

        <div id="part4">
            <?php require('../php/stripMid.php'); ?>
            </div>
        </div>  
		
		<div id="part5">
			<?php require('../php/footer.php'); ?>
		</div>
	
	
		
	
	
	
	</body>
</html