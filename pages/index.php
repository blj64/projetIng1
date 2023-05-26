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
		<link rel="stylesheet" href="../css/underHeader.css">
		<link rel="stylesheet" href="../css/iaPauAcc.css">
		<link rel="stylesheet" href="../css/join.css">
        <link rel="stylesheet" href="../css/footer.css">
        <link rel="stylesheet" href="../css/dataCAcc.css">
		<link rel="stylesheet" href="../css/signup.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Accueil</title>
	</head>
	<body>
		<div id="part1">
			<?php include('../php/header.php'); ?>
		</div>
		<div id="part2">
			<?php include('../php/underHeader.php'); ?>
		</div>
		<div id="part3">
			<?php include('../php/iaPauAcc.php'); ?>
		</div>
		<div id="part4">
			<?php include('../php/stripMid.php'); ?>
			</div>
		</div>
		<div id="part5">
			<?php include('../php/dataCAcc.php'); ?>
		</div>
		<div id = "part6">
		<?php include('../php/join.php'); ?>
		</div>
		<div id="part7">
			<?php include('../php/footer.php'); ?>
		</div>
	
	
		
	
	
	
	</body>
</html