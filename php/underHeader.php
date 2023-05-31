<div id="UnderHeader">
    <div id="underHeaderContent">
    <?php 
    
    if(isset($_SESSION['id'])){
        if(roleUser($_SESSION['id'], ADMIN)){
            echo('<h2>Bienvenue sur votre espace Administrateur</h2>');
        }
        if(roleUser($_SESSION['id'], STUDENT)){
            echo('<h2>Bienvenue sur votre espace Utilisateur</h2>');
        }
        if(roleUser($_SESSION['id'], MANAGER)){
            echo('<h2>Bienvenue sur votre espace Manager</h2>');
        }
    }else{ 
        echo('<h2>IA PAU</h2>
        <h1>Découvrez nos Challenges</h1>
        <div>
            ctn
        </div>');
    }
    ?>
    </div>
    <div id="cssUnderHeaderForm1">
    
    </div>
    <div id="cssUnderHeaderForm2">    
    </div>
    
</div>

