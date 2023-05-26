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
    <?php 
    //require_once '../php/header.php';
    
    if (SESSION_STATUS() == PHP_SESSION_NONE)
        session_start();

    $retrive = isset($_SESSION['old']);
     ?>
    <div class="main">
        <div class="center">

            <div class="box-left" style="display: none;">
                <h1>Venez challenger vos données</h1>
            </div>
            
            <div class="sign-box">
                <img src="" alt="">
                <h1>Inscrivez-vous à IA Pau</h1>
                <form action="/php/verifFormSignUp.php" method="POST">
                    <input type="text" name="firstname" id="name" placeholder="prenom" value="<?php if($retrive) echo $_SESSION['old']['firstname'];?>">
                    <span class="error-msg"><?php  if (isset($_SESSION['error']['firstname'])) echo $_SESSION['error']['firstname'];  ?></span>
                    
                    <input type="text" name="lastname" id="name" placeholder="nom" value="<?php if($retrive) echo $_SESSION['old']['lastname'];?>">
                    <span class="error-msg"><?php  if (isset($_SESSION['error']['lastname'])) echo $_SESSION['error']['lastname'];  ?></span>
                    
                    <input type="text" name="email" id="email" placeholder="email" value="<?php if($retrive) echo $_SESSION['old']['email'];?>">
                    <span class="error-msg"><?php  if (isset($_SESSION['error']['email'])) echo $_SESSION['error']['email'];  ?></span>
                    
                    <input type="password" name="password" id="password" placeholder="mot de passe" value="<?php if($retrive) echo $_SESSION['old']['password'];?>">
                    <span class="error-msg"><?php  if (isset($_SESSION['error']['password'])) echo $_SESSION['error']['password'];  ?></span>
                    
                    <input type="password" name="passwordV" id="passwordV" placeholder="ré-entrer le mot de passe">
                    <span class="error-msg"><?php  if (isset($_SESSION['error']['passwordV'])) echo $_SESSION['error']['passwordV'];  ?></span>
                    
                    <input type="text" name="number" id="number" placeholder="numero" value="<?php if($retrive) echo $_SESSION['old']['number   ']; unset($_SESSION['old']);?>">
                    <span class="error-msg"><?php  if (isset($_SESSION['error']['number'])) echo $_SESSION['error']['number'];  ?></span>
                    
                    <input type="submit" value="S'inscrire">    
                    <p class="message">Déjà inscrit? <a href="/pages/signIn.php">Connectez-vous</a></p>
                </form>
                
            </div>

        </div>
    </div>

    <?php //require_once '../php/footer.php'; ?>
</body>
</html>