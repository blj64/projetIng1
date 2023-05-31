<?php
    session_start();
    include('../php/bdd.php');
    /*connect_db();
    echo(is_connected_db());
    $donnees = getUserByEmail($_SESSION['login']);
    $isConnected= isset($_SESSION['login']);
    echo($isConnected);*/
                    
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="stylesheet" href="../css/profil.css">
		<link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/underHeader.css">
        <link rel="stylesheet" href="../css/stripmid.css">
        <link rel="stylesheet" href="../css/footer.css">
        
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Accueil</title>
	</head>
	<body>
		<div id="part1Profil">
			<?php include('../php/header.php'); ?>
		</div>
        <div id="part3Profil">
            <div class="sign-box">
                
                <h1> Vous êtes sur votre profil </h1> <br>
                <?php 
                    
                ?>
                
                <form action="/php/modifProfil.php" method="POST">

                <?php if(isset($_SESSION['user']['id'])){
                    $donnees = getUserByEmail($_SESSION['user']['login']);
                    echo('<input type="text" name="firstname" id="firstName" placeholder="prenom" value="'.$donnees["firstName"].'">    
                    
                
                    <input type="text" name="lastname" id="lastName" placeholder="nom" value="'.$donnees["lastName"].'">

                    
                    <input type="text" name="number" id="number" placeholder="numéro" value="'.$donnees["number"].'">
                
                    
                    <input type="text" name="email" id="email" placeholder="email" value="'.$donnees["email"].'">');
                    
                    
                    if(roleUser($_SESSION['user']['id'], STUDENT)){
                        echo('<input type="text" name="school" id="school" placeholder="école" value="'.$donnees["school"].'">
                    

                        <input type="text" name="city" id="city" placeholder="ville" value="'.$donnees["city"].'">');
                    }
                    if(roleUser($_SESSION['user']['id'], MANAGER)){
                        echo(`<input type="text" name="company" id="company" placeholder="entreprise" value="`.$donnees["company"].`">`);
                    } 
                    
                    
                    echo('<input type="submit" value="modifier">');
                }else {
                    header("Location: /pages/signIn.php");
                }
                ?>  
                    
                </form>
                
            </div>
		</div>
		
		<div id="part5Profil">
			<?php include('../php/footer.php'); ?>
		</div>
	
	
		
	
	
	
	</body>
</html