<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/myGroup.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
    <title>IAPau my group</title>
</head>
<body>
    <?php require_once $_SERVER["DOCUMENT_ROOT"] . '/php/header.php'; ?>

    <div class="main">
        <div class="center">
            <nav class="menu">
            </nav>
            <div class="rest">
                <div class="all-box">
                    <h1>Vous n'êtes dans aucune équipe actuellement !</h1>
                    <a href="/pages/challenges.php">Rejoindre la compétition</a>
                </div>
            </div>
        </div>
    </div>


    <?php require_once $_SERVER["DOCUMENT_ROOT"] . '/php/footer.php'; ?>
</body>
</html>