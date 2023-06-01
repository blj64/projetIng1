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
    require_once '../php/header.php';
    
    if (SESSION_STATUS() == PHP_SESSION_NONE)
        session_start();

    $retrive = isset($_SESSION['old']);
     ?>
    <div class="main">
        <div class="center">
            
            <div class="sign-box">
                <img src="" alt="">
                <h1>Connectez-vous à IA Pau</h1>
                <form action="/php/login.php" method="POST">
                    
                    <input type="text" name="login" id="login" placeholder="email" value="<?php if($retrive) echo $_SESSION['old']['login']; unset($_SESSION['old']);?>">
                    <span class="error-msg"><?php  if ($retrive && isset($_SESSION['error']['login']))  echo $_SESSION['error']['login'];   ?></span>
                    
                    <input type="password" name="password" id="password" placeholder="mot de passe" value="<?php if($retrive) echo $_SESSION['old']['password'];?>">
                    <span class="error-msg"><?php  if ($retrive && isset($_SESSION['error']['pwd'])) {echo $_SESSION['error']['pwd']; unset($_SESSION['error']);}  ?></span>
                    
                    <input type="submit" value="Se connecter">

                <p class="message">Pas encore inscrit? <a href="/pages/signUp.php">Créer votre compte</a></p>
                </form>
                
            </div>

        </div>
    </div>

    <?php require_once '../php/footer.php'; ?>
</body>
</html>