<header>
    <link rel="stylesheet" href="/css/header.css">
    <div class="left-part">
    </div>

    <div class="center-part">

        <div class="logo">
            <a href="/pages/">
                <img src="/asset/img/iapau_round.png" alt="logo">
            </a>
        </div>

        <div class="main-menu">
            <?php
            /* auto generate the menu */
            /* adapt the menu to the user */

            const PAGES = [  // pages accessible by all
                'Accueil' => '/pages/accueilAdmin.php',
                'Data Challenges' => '/pages/dataChallenges.php',

                'CUSTOME' => [ //custom menu for each role

                    'USER' => [ // menu for all logged user
                        'Mon équipe' => '/pages/myGroup.php',
                    ],

                    'MANAGER' => [ // menu for manager
                        'Mon équipe' => '/pages/myGroup.php',
                        'Mes challenges' => '/pages/myChallenges.php',
                    ],

                    'ADMIN' => [ // menu for admin
                        'Mes challenges' => '/pages/myChallenges.php',
                        'Gestion des utilisateurs' => '/pages/manageUsers.php',
                    ],
                ],

                // back to pages accessible by all
                'Contact' => '/pages/contact.php',
                'Profile' => '/pages/about.php'
            ];

            require_once($_SERVER['DOCUMENT_ROOT'] . '/php/bdd.php');
            if (!is_connected_db())
                connect_db();

            $role = null;
            /* check if the user is connected then get it's role*/
            if (isset($_SESSION['user'])) {
                $role = 'USER';
                $role = (roleUser($_SESSION['user']['id'], MANAGER)) ? "MANAGER" : "$role";
                $role = (roleUser($_SESSION['user']['id'], ADMIN)) ? "ADMIN" : "$role";
            }

            /* get the url of the page */
            $window_url = explode('/',  $_SERVER['REQUEST_URI']);
            $current_page = end($window_url);

            foreach (PAGES as $name => $url) {
                /* un utilisateur non connecté ne peut pas accéder à la page d'accueil*/
                if ($role == NULL && $name == "Accueil")
                    continue;

                $added = '';
                if ($name == 'CUSTOME') {
                    if ($role != null) {
                        foreach (PAGES[$name][$role] as $name => $url) {
                            $split_url = explode('/', (string)$url);    
                            if ($current_page === end($split_url))
                                $added = 'class="here"';

                            echo "<a href='$url' $added>$name</a>";
                        }
                    }
                } else {
                    $split_url = explode('/', (string)$url);
                    if ($current_page === end($split_url))
                        $added = 'class="here"';

                    echo "<a href='$url' $added>$name</a>";
                }
            }
            ?>

        </div>
    </div>

    <div class="right-part">
        <?php
        /* check if the user is connected then display the login or the profile picture */
        if (!isset($_SESSION['user'])) { 
            /* if not connected */
            echo '<div class="dropdown">
                        <img id="menu" src="../asset/icon/menu.png" alt="3barres">
                        <div class="dropdown-content">
                            <a href="/pages/signUp.php">Inscription</a>
                            <a href="/pages/signIn.php">Connexion</a>
                        </div>
                    </div>';        
        } else {    
            /* if connected */
            echo '<p>'.$_SESSION["user"]["login"].'</p>';
            echo '<a href="/pages/profile.php" class="pp"><img src="/asset/icon/profile.ico" alt="Profile P"></a>';
            echo '<a href="/php/logoff.php" class="pp" style="margin-right: 5%;"><img src="/asset/icon/logoff.jpg" alt="logoff"></a>';
        }
        ?>
    </div>
</header>

<!--		old version     -->
<!--
<div id="header">
    <div id="contenair">
        <div id="Z0" class="spaceBetweenElt">
            <img id="logo" src="../asset/img/iapau_round.png" alt="">
        </div>
        <div id="Z1"class="spaceBetweenElt">
		    <a class="spaceBetweenLink" href="#IAPauAcc">IA Pau</a>
		    <a href="#DCAcc"> Data Challenge</a>
            </div>
        <div id="Z3">
            <div class="dropdown">
                <img id="menu" src="../asset/icon/menu.png" alt="3barres">
                <div class="dropdown-content">
                            <a href="../pages/signUp.php">Inscription</a>
                            <br>
                            <br>
                            <a href="">Connexion</a>
                        </div>
                <?php
                /*if(isset($_SESSION['login'])){
                        echo('<div class="dropdown-content">
                            <a href="../pages/signUp.php">Inscription</a>
                            <br>
                            <br>
                            <a href="">Connexion</a>
                        </div>');
                    }else{
                        if(roleUser($_SESSION['login'], ADMIN)){
                            echo('<div class="dropdown-content">
                            <a href="../pages/index.php">Deconnexion</a>
                            <br>
                            <br>
                            <a href="">Modifier les droits</a>
                            <br>
                            <br>
                            <a href="">Gérer les Datas Challenges</a>
                            <br>
                            <br>
                            <a href="">Profil</a>
                        </div>');
                        }
                        if(roleUser($_SESSION['login'], MANAGER)){
                            echo('<div class="dropdown-content">
                            <a href="../pages/index.php">Deconnexion</a>
                            <br>
                            <br>
                            <a href="">Modifier les Datas Challenges</a>
                            <br>
                            <br>
                            <a href="">Gérer les équipes</a>
                            <br>
                            <br>
                            <a href="">Profil</a>
                        </div>');
                        }
                        if(roleUser($_SESSION['login'], ADMIN)){
                            echo('<div class="dropdown-content">
                            <a href="../pages/index.php">Deconnexion</a>
                            <br>
                            <br>
                            <a href="">Modifier les droits</a>
                            <br>
                            <br>
                            <a href="">Gérer les Datas Challenges</a>
                            <br>
                            <br>
                            <a href="">Profil</a>
                        </div>');
                        }
                    }*/
                ?>
            </div>        
        </div>
    </div>
</div> 


                -->