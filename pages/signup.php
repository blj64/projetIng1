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
    <?php //require_once '../php/header.php'; ?>

    <div class="main">
        <div class="center">

            <div class="box-left">
                <h1>Venez challenger vos données</h1>
            </div>
            
            <div class="sign-box">
                <img src="" alt="">
                <h1>Inscrivez-vous à IA Pau</h1>
                <form action="/php/inscription.php" method="POST">
                    <input type="text" name="firstname" id="name" placeholder="prenom">
                    <input type="text" name="lastname" id="name" placeholder="nom">
                    <input type="text" name="email" id="email" placeholder="email">
                    <input type="password" name="password" id="password" placeholder="mot de passe">
                    <input type="password" name="passwordV" id="passwordV" placeholder="ré-entrer le mot de passe">
                    <input type="text" name="number" id="number" placeholder="numero">
                    <input type="submit" value="S'inscrire">
                </form>
                
            </div>

        </div>
    </div>

    <?php //require_once '../php/footer.php'; ?>
</body>
</html>