<?php
	
	session_start();
	require 'class/bdd.php';
	require 'class/user.php';

	$user = new user();
	$bdd = new bdd();

	$bdd->connect();

	if (isset($_SESSION['id'])) 
	{
		header('Location:index.php');
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Connexion</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body id="bodyConnexion">
	<main id="mainConnexion">
		<section id="connexion">
			<h1 id="titleConnexion">Connection <span> use your login and password</span></h1>
			
			<form  action="" method="post" id="formConnexion">

				<label for="login" class="labelConnexion">Identifiant</label>
				<input type="text" name="login" class="inputConnexion" required><br>

				<label for="password" class="labelConnexion">Mot de passe</label>
				<input type="password" name="password" class="inputConnexion" id="password">
				<span class="show-password">afficher</span>

				<input type="submit" name="send" class="inputConnexion"> 
			</form>

			<?php

			if(isset($_POST["send"]))
			{
				$user->connexion($_POST["login"],$_POST["password"], $bdd);

			}

			?>
		</section>
	</main>
	<script type="text/javascript" src="js/jquery-3.5.1.min"></script>
	<script type="text/javascript" src="js/buttonPassword.js"></script>
</body>
</html>

