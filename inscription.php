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
	<title>Inscritpion</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body id="bodyInscription">
	<main id="mainInscription">
		<section id="inscription">
			<h1 id="titleInscription">INSCRIPTION <span>Bienvenue</span> </h1>
			<form method="post" action="" id="formInscription">
				<label for="login" class="labelInscription">Login :</label><input type="text" name="login" class="inputInscription" required><br />
				<label for="mdp" class="labelInscription">Mot de passe :</label>  <input type="password" name="password" class="inputInscription" required><br />
				<label for="confMdp" class="labelInscription">Confirmer votre Mot de Passe :</label> <input type="password" name="confPassword" class="inputInscription" required><br />

				<label for="adresse" class="labelInscription">Adresse :</label> <input type="text" name="adresse" class="inputInscription"><br />

				<input type="submit" value="Inscritpion" name="newUser">
			</form>
			<?php

			if (isset($_POST["newUser"])) 
			{
				if ($user->inscription($_POST['login'], $_POST["password"], $_POST['confPassword'], $_POST['adresse'], $bdd) == "userCheck") 
				{
					echo "Compte créer";
					header('Location:connexion.php');
				}
				elseif ($user->inscription($_POST['login'], $_POST["password"], $_POST['confPassword'], $_POST['adresse'], $bdd) == "userExist") 
				{
					echo "ce login existe";
				}
				elseif ($user->inscription($_POST['login'], $_POST["password"], $_POST['confPassword'], $_POST['adresse'], $bdd) == "mdpFaux") 
				{
					echo "mot de passe !=";
				}
				elseif ($user->inscription($_POST['login'], $_POST["password"], $_POST['confPassword'], $_POST['adresse'], $bdd) == "logVide") 
				{
					echo "champ manquant";
				}
			}
			?>
		</section>
	</main>

</body>
</html>

