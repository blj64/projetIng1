<?php session_start();
include( '../php/bdd.php');
connect_db();
echo($_SESSION);    
 ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/signup.css">
        <title>IAPau</title>
    </head>
<body>
    
    <div class="main">
        <div class="center">

            <div class="box-left">
                <h1>Venez challenger vos données</h1>
            </div>
            
            <div class="sign-box">
                <img src="" alt="">
                <h1>Créer votre team</h1>
                <form action="/php/login.php" method="POST">
                    <?php   
                    if(isset($_SESSION['user']['id'])){
                        $donnees = getUserByEmail($_SESSION['user']['login']);
                    }
                    ?>
                    
                    <input type="text" name="teamName" id="teamName" placeholder="Le nom de votre team" value="">
                    <span class="error-msg"><?php  if (isset($_SESSION['error']['teamName'])) echo $_SESSION['error']['teamName'];  ?></span>
                    
                    <input type="text" name="lvlStudy" id="lvlStudy" placeholder="Niveau d'étude" value="<?php echo($donnees['lvlStudy']);?>">
                    <span class="error-msg"><?php  if (isset($_SESSION['error']['lvlStudy'])) echo $_SESSION['error']['lvlStudy'];  ?></span>

                    <input type="text" name="school" id="school" placeholder="Votre école" value="<?php echo($donnees['school']);?>">
                    <span class="error-msg"><?php  if (isset($_SESSION['error']['school'])) echo $_SESSION['error']['school'];  ?></span>

                    <input type="text" name="city" id="city" placeholder="Votre ville" value="<?php echo($donnees['city']);?>">
                    <span class="error-msg"><?php  if (isset($_SESSION['error']['city'])) echo $_SESSION['error']['city'];  ?></span>

                    <input type="text" name="numStudent" id="numStudent" placeholder="Votre numéro étudiant" value="<?php ?>">
                    <span class="error-msg"><?php  if (isset($_SESSION['error']['numStudent'])) echo $_SESSION['error']['numStudent'];  ?></span>

                    <div class="radioTeam">

                        <input type="checkbox" name="createGroup" id="createGroup">
                        <label id="nameCreateGroupe">Créer le groupe</label>
                    </div>
                        <span class="error-msg"><?php  if (isset($_SESSION['error']['createGroup'])) echo $_SESSION['error']['createGroup'];  ?></span>

                        
                    
                    
                    <input type="submit" value="Créer votre équipe">
                </form>
                
            </div>

        </div>
    </div>

    <?php //require_once '../php/footer.php'; ?>
</body>
</html>