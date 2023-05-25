<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="stylesheet" href="../css/accueilAdmin.css">
		<link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/underHeader.css">
        <link rel="stylesheet" href="../css/stripmid.css">
        <link rel="stylesheet" href="../css/footer.css">
        
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Accueil</title>
	</head>
	<body>
		<div id="part1Admin">
			<?php include('../php/header.php'); ?>
		</div>
        <div id="part2Admin">
            <?php include('../php/underHeader.php'); ?>
		</div>
        <div id="part3Admin">
            <div id ="cardAdmin">
                <div id="card1Admin" class="spaceBetweenCards">
                    <a href="">carte 1</a>
                </div>
                <div id="card2Admin" class="spaceBetweenCards">
                    <a href="">carte 2</a> 
                </div>
                <div id="card3Admin">
                    <a href="">carte 3</a>
                </div>
            </div>
		</div>

        <div id="part4Admin">
            <?php include('../php/stripMid.php'); ?>
            </div>
        </div>  
		
		<div id="part5Admin">
			<?php include('../php/footer.php'); ?>
		</div>
	
	
		
	
	
	
	</body>
</html