<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/myGroup.css">
    <title>IAPau my group</title>
</head>
<body>
    <?php //require_once $_SERVER["DOCUMENT_ROOT"] . '/php/header.php'; ?>

    <div style="height: 10vh; background-color:blueviolet;">
        <h1>I'm a header</h1>
    </div>

    <div class="main">
        <div class="center">
            <nav class="menu">
            </nav>
            <div class="rest">
                <div class="all-box">
                    <h1>Vous n'êtes dans aucune équipe actuellement !</h1>
                    <a href="/pages/DataC.php">Rejoindre la compétition</a>
                </div>
            </div>
        </div>
    </div>

    
    <div style="height: 10vh; background-color:red;padding-top:0px;">
        <h1>I'm a footer</h1>
    </div>

    <?php //require_once $_SERVER["DOCUMENT_ROOT"] . '/php/footer.php'; ?>
</body>
</html>