<?php session_start();
require( '../php/bdd.php');
connect_db(); 

if (session_status() == PHP_SESSION_NONE)
    session_start();

if(!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])){
    header('Location: /pages/index.php?error=notConnected');
    exit();
}

if(!isset($_GET['idDataC'])){
    header('Location: /pages/index.php?error=missingId');
    exit();
}

$challenge = getDataChallengeById($_GET['idDataC']);

if(!$challenge){
    header('Location: /pages/index.php?error=challengeNotFound');
    exit();
}

$challenge = $challenge[0];

if (roleUser($_SESSION['user']['id'], STUDENT))
    $data = getStudentByIdUser($_SESSION['user']['id']);

if (isset($data))
{
    $data = $data[0];
     
    if (getGroupByStudentId($data['id']))
    {
        header('Location: /pages/index.php?error=Vous êtes déjà inscrit à un groupe');
        exit();
    }
}   
    


 ?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/signup.css">
        <title>IAPau</title>
    </head>
<body>
    <?php require('../php/header.php'); ?>

    <div class="main">
        <div class="center">

        <!--
            <div class="box-left">
                <h1>Venez challenger vos données</h1>
            </div>
-->
            <div class="sign-box">
                <img src="" alt="">
                <h1>Etes-vous étudiant ?</h1>
                <form action="/php/signStudent.php" method="POST" onsubmit="return verif_form()">
                    <?php   
                    if(isset($_SESSION['user']['id'])){
                        $donnees = getUserByEmail($_SESSION['user']['login']);
                    }
                    ?>
                    <input type="hidden" name="id" value="<?php echo $_SESSION['user']['id'] ?>">
                    <input type="hidden" name="idDataC" value="<?php echo $_GET['idDataC'] ?>">
                    <input type="text" name="lvlStudy" id="lvlStudy" placeholder="Niveau d'étude" value="<?php if(isset($data['lvStudy'])) echo $data['lvStudy'] ?>">
                    <span class="error-msg"><?php  if (isset($_SESSION['error']['lvlStudy'])) echo $_SESSION['error']['lvlStudy'];  ?></span>

                    <input type="text" name="school" id="school" placeholder="Votre école" value="<?php if(isset($data['school'])) echo $data['school'] ?>">
                    <span class="error-msg"><?php  if (isset($_SESSION['error']['school'])) echo $_SESSION['error']['school'];  ?></span>

                    <input type="text" name="city" id="city" placeholder="Votre ville" value="<?php if(isset($data['city'])) echo $data['city'] ?>">
                    <span class="error-msg"><?php  if (isset($_SESSION['error']['city'])) echo $_SESSION['error']['city'];  ?></span>

                    <input type="text" name="numStudent" id="numStudent" placeholder="Votre numéro étudiant (optionnel)" value="">
                    <span class="error-msg"><?php  if (isset($_SESSION['error']['numStudent'])) echo $_SESSION['error']['numStudent'];  ?></span>

                    <div class="radioTeam">

                        <input type="checkbox" name="createGroup" id="createGroup" onchange="show()">
                        <label id="nameCreateGroupe">Créer un groupe</label>
                    </div>
                        <span class="error-msg"><?php  if (isset($_SESSION['error']['createGroup'])) echo $_SESSION['error']['createGroup'];  ?></span>

                    
                    <input style="display:none;" type="text" name="teamName" id="teamName" placeholder="Le nom de votre team" value="">
                    <span class="error-msg"><?php  if (isset($_SESSION['error']['teamName'])) echo $_SESSION['error']['teamName'];  ?></span>
                        
                    
                    
                    <input onclick="submit()" type="submit" value="Créer votre équipe">
                </form>
                
            </div>

        </div>
    </div>

    <?php require '../php/footer.php'; ?>
</body>

<script src="/js/sign.js"></script>
</html>