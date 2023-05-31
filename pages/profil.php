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
                    $donnees = getUserByEmail($_SESSION['user']['login']);
                ?>
                
                <form action="/php/modifProfil.php" method="POST">

                    
                    <input type="text" name="firstname" id="firstName" placeholder="prenom" value="<?php echo($donnees["firstName"]); ?>">
                    
                
                    <input type="text" name="lastname" id="lastName" placeholder="nom" value="<?php echo($donnees["lastName"]);?>">

                    
                    <input type="text" name="number" id="number" placeholder="numéro" value="<?php echo($donnees["number"]);?>">
                
                    
                    <input type="text" name="email" id="email" placeholder="email" value="<?php echo($donnees["email"]);?>">
                    
                    <?php 
                    if(roleUser($_SESSION['user']['id'], STUDENT)){
                        echo(`<input type="text" name="school" id="school" placeholder="school" value="<?php echo(`.$donnees["school"].`);?>">
                    

                        <input type="text" name="city" id="city" placeholder="city" value="<?php echo(`.$donnees["city"].`);?>">`);
                    }
                    if(roleUser($_SESSION['user']['id'], MANAGER)){
                        echo(`<input type="text" name="company" id="company" placeholder="entreprise" value="<?php echo(`.$donnees["company"].`);?>">`);
                    } 
                    ?>  
                    
                    <input type="submit" value="modifier">

                    
                </form>
                
            </div>
		</div>
		
		<div id="part5Profil">
			<?php include('../php/footer.php'); ?>
		</div>
	
	
		
	
	
	
	</body>
</html