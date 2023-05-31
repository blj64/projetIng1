<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="stylesheet" href="../css/accueil.css">
		<link rel="stylesheet" href="../css/header.css">
		<link rel="stylesheet" href="../css/join.css">
        <link rel="stylesheet" href="../css/footer.css">
		<!--<link rel="stylesheet" href="../css/signup.css">-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Accueil</title>
	</head>
	<body>
		<div id="part1">
			<?php include('../php/header.php'); ?>
        </div>
		<div id = "part6">
		<?php include('../php/join.php'); ?>
		</div>
		<div id="part7">
			<?php include('../php/footer.php'); ?>
		</div>	
	</body>
</html