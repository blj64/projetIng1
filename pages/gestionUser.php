<?php

if (session_status() == PHP_SESSION_NONE)
    session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /pages/signIn.php?error=NotConnected");
    exit();
}

require_once "../php/bdd.php";
if (!is_connected_db())
    connect_db();

if (!roleUser($_SESSION['user']['id'], ADMIN)) {
    header("Location: /pages/signIn.php?error=NotAdmin");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/gestionUser.css">
    <title>Gestion des utilisateurs</title>
</head>

<body>
    <?php require_once "../php/header.php"; ?>

    <div class="main">
        <div class="left-part-main">
            <div class="banner">
                <button onclick="show_vierge()">Créer un utilisateur</button>
                <h1>Gestion des utilisateurs</h1>
            </div>

            <div class="view-user">
                <div class="desc-banner">
                    <p>Les administrateurs</p>
                </div>
                <div class="user-list">

                    <?php
                    $admin = getAllAdmins();
                    foreach ($admin as $id => $value) {
                        echo '
                                <div onclick="show(this)" class="user" id=' . $value['id'] . '>
                                    <input id=email type=hidden value="' . $value['email'] . '">
                                    <input id=number type=hidden value="' . $value['number'] . '">
                                    <input id=role type=hidden value"ADMIN">
                                    <div class="profile-picture">
                                        <img id=img src="/asset/icon/profile.ico" alt="profile-picture">
                                    </div>
                                    <div class="text-intel">
                                        <p id=name>' . $value['lastName'] . ' ' . $value['firstName'] . '</p>
                                    </div>
                                </div>';
                    }
                    unset($admin);
                    ?>

                </div>
            </div>

            <div class="view-user">
                <div class=desc-banner>
                    <p>Les gestionnaires</p>
                </div>
                <div class="user-list">

                    <?php
                    $manager = getAllManagers();
                    
                    $event = getManagersDataChallenges();
                    $idEvent = array();
                    foreach ($event as $id => $value) {
                        $idEvent[$value['id']] = $value['idDataC'];
                    }

                    foreach ($manager as $id => $value) {
                        echo '
                            <div onclick="show(this)" class="user" id=' . $value['id'] . '>
                                <input id=email type=hidden value="' . $value['email'] . '">
                                <input id=number type=hidden value="' . $value['number'] . '">
                                <input id=role type=hidden value="MANAGER">
                                <input id=company type=hidden value="' . $value['company'] . '">
                                <input id=startDate type=hidden value="' . $value['startDate'] . '">
                                <input id=endDate type=hidden value="' . $value['endDate'] . '">
                                <input id=idEvent type=hidden value="' . $idEvent[$value['id']] . '">
                                <div class="profile-picture">
                                    <img id=img src="/asset/icon/profile.ico" alt="profile-picture">
                                </div>
                                <div class="text-intel">
                                    <p id=name>' . $value['lastName'] . ' ' . $value['firstName'] . '</p>
                                </div>
                            </div>';
                    }
                    unset($manager);
                    unset($event);
                    unset($idEvent);
                    ?>
                </div>
            </div>

            
            <div class="view-user">
                <div class=desc-banner>
                    <p>Les étudiants</p>
                </div>
                <div class="user-list">

                    <?php
                    $student = getAllStudents();

                    foreach ($student as $id => $value) {
                        $groupName = getGroupById($value['idGroup'])[0]["name"];

                        echo '
                            <div onclick="show(this)" class="user" id=' . $value['id'] . '>
                                <input id=mail type=hidden value="' . $value['email'] . '">
                                <input id=number type=hidden value="' . $value['number'] . '">
                                <input id=role type=hidden value="STUDENT">
                                <input id=idGroup type=hidden value="' . $groupName . '">
                                <input id=lvStudy type=hidden value="' . $value['lvStudy'] . '">
                                <input id=school type=hidden value="' . $value['school'] . '">
                                <input id=city type=hidden value="' . $value['city'] . '">
                                <div class="profile-picture">
                                    <img id=img src="/asset/icon/profile.ico" alt="profile-picture">
                                </div>
                                <div class="text-intel">
                                    <p id=name>' . $value['lastName'] . ' ' . $value['firstName'] . '</p>
                                </div>
                            </div>';
                    }
                    unset($student);
                    ?>
                </div>
            </div>
            

            <div class="view-user">
                <div class=desc-banner>
                    <p>Les utilisateurs</p>
                </div>
                <div class="user-list">

                    <?php
                    $user = getAllUsers();
                    $count = 0;
                    foreach ($user as $id => $value) {
                        if(roleUser($value['id'], ADMIN) || roleUser($value['id'], MANAGER) || roleUser($value['id'], STUDENT))
                        {
                            $count++;
                            continue;
                        }
                        echo '
                            <div onclick="show(this)" class="user" id=' . $value['id'] . '>
                                <input id=email type=hidden value=' . $value['email'] . '>
                                <input id=number type=hidden value=' . $value['number'] . '>
                                <input id=role type=hidden value="USER">
                                <div class="profile-picture">
                                    <img id=img src="/asset/icon/profile.ico" alt="profile-picture">
                                </div>
                                <div class="text-intel">
                                    <p id=name>' . $value['lastName'] . ' ' . $value['firstName'] . '</p>
                                </div>
                            </div>';
                    }

                    if ($count == count($user))
                        echo '<h4>Aucun utilisateur</h4>';
                    unset($manager);
                    ?>
                </div>
            </div>
        </div>

        <div id=fake_preview>
        </div>

    </div>

    <div id=preview class="right-preview">
        <input type="hidden" name="id" id=preview-id value="666">
        <input type="hidden" name="role" id=preview-role value="NONE">
        <p class="quit-btn" id=quit-btn onclick="change_preview()">>></p>
        <div class="preview-top">
            <div class="preview-pp">
                <img src="/asset/icon/profile.ico" alt="profile-picture">
            </div>
            <div class="preview-intel">
                <input type="text" id=prev-lastName placeholder="Last Name" value="DURAND">
                <input type="text" id=prev-firstName placeholder="First Name" value="Nicolas">
            </div>
        </div>
        <div class="preview-mid">
            <div class="preview-mail">
                <input type="text" id=prev-email placeholder="Mail" value="durandnico@cy-tech.fr">
                <input type="text" id=prev-number placeholder="Numéro" value="06 62 20 89 86">
            </div>
        </div>
        <div class="preview-bot">
            <div class="preview-custom">
                <?php 
                $user = getUserByEmail("admin@cy-tech.fr");
                    if(roleUser($user['id'], MANAGER))
                    {
                        echo '<input type="text" id=prev-company placeholder="Entreprise" value="IA Pau">';
                        echo '<input type="date" id=prev-dateD  value="2002-03-04">';
                        echo '<input type="date" id=prev-dateF  value="2004-03-04">';
                        echo '<input type="text" id=prev-respo  value="id_data">';
                    }
                    else if(roleUser($user['id'], STUDENT))
                    {
                        echo '<input type="text" id=prev-City placeholder="Ville" value="Pau">';
                        echo '<input type="text" id=prev-School placeholder="Ecole" value="EISTI">';
                        echo '<input type="text" id=prev-Lvl  value="L3">';
                    }
                ?>
            </div>
        </div>

        <div class=preview-validation-btn>
            <button onclick="deleteUser()" id=suppr>Supprimer utilisateur</button>
            <button onclick="MakeManager()" id=gestionner>Faire gestionnaire</button>
            <button onclick="updateUser()" id=modif>Appliquer modification</button>
            <button onclick="createUser()" id=creation>Créer utilisateur</button>
        </div>
    </div>

    <?php // require_once "../php/footer.php"; 
    ?>
</body>

<script src="/js/gestionUser.js"></script>
</html>