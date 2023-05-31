<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="stylesheet" href="../css/accueil.css">
		<link rel="stylesheet" href="../css/challengesPage.css">
		<link rel="stylesheet" href="../css/join.css">
        <link rel="stylesheet" href="../css/footer.css">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Accueil</title>
	</head>
	<body>
		<div id="part1">
			<?php include('../php/header.php'); ?>
        </div>
        <div id ="part2">
            <div id="dataPage">
                <div id="Z0DP">
                    <p>Nom du data Challenge<p>
                    <div id="formeZ01">
                    </div>
                    <div id="formeZ02">
                    </div>
                    <div id="formeZ03">
                    </div>
                </div>
                <div id="Z1DP">
                    <div id="img-dataPage" class="imgSpaceBetween">
                        <img width="400px" src="https://iapau.org/wp-content/uploads/2023/01/dc-decembre-2022-archive-site-web.jpg" alt="" class="imgSpaceBetween">
                    </div>
                    <div id="info-dataPage"> 
                        <div id="archive">
                            <a href="...">Archives  Data Challenges</a>
                        </div>
                        <div id="date">
                            <p> date <p> 
                        </div>   
                    </div>    
                </div>
                <div id="Z2DP">
                    <p>ctn<p>
                </div>
            </div>
        </div>
		<div id = "part6">
		<?php include('../php/join.php'); ?>
		</div>
		<div id="part7">
			<?php include('../php/footer.php'); ?>
		</div>	
	</body>
</html