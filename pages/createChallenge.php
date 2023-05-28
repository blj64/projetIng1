<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/createChallenge.css">
    <title>Créer Event</title>
</head>

<body>
    <?php require '../php/header.php'; ?>

    <div class="main">
        <h1>Creation de Data Event</h1>
        <div class="data-img">
            <div class="rendu-box">
                <form class="box" method="post" action="" enctype="multipart/form-data">
                    <div class="drop-zone">
                        <span class="drop-zone__prompt">Drop image here or <span id="click">click</span> to upload</span>
                        <input type="file" name="myFile" id=main-image class="drop-zone__input">
                    </div>
                    <div class="box__uploading">Uploading…</div>
                    <div class="box__success">Upload success!</div>
                    <div class="box__error">Upload error! <span id="add_error"></span>.</div>
                </form>
            </div>

            <div class="date">
                <div>
                    <label for="date">Date de début</label>
                    <input type="date" name="startDate" id="startDate">
                </div>
                <div>
                    <label for="date">Date de final</label>
                    <input type="date" name="endDate" id="endDate">
                </div>
            </div>
        </div>
        
        <div class="desc">
            <input type="text" id="main-title" name="main-title" placeholder="Titre de l'event">
            <textarea id="main-desc" name="main-description" placeholder="Description de l'event"></textarea>
        </div>
        
        <div id=list-subject class="list-subject">
            <div class="subject-btn">
                <button id=add_sub onclick="AddSubject()">Ajouter Sujet</button>
            </div>
        </div>

        <button onclick="valider()" id=valid>Créer l'event</button>
    </div>

    <?php //require '../php/footer.php'; 
    ?>
</body>
<script src="/js/challenge.js"></script>
</html>