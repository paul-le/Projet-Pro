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
</head>
<body>
	<main>
		<form method="post" action="">
			Login : <input type="text" name="login" required>
			Mot de passe : <input type="password" name="password" required>
			Confirmer votre Mot de Passe : <input type="password" name="confPassword" required>
			
			<input type="submit" value="Inscritpion" name="newUser">
		</form>
		<?php
	
		if (isset($_POST["newUser"])) 
		{
			if ($user->inscription($_POST['login'], $_POST["password"], $_POST['confPassword'], $bdd) == "userCheck") 
			{
				echo "Compte créer";
				header('Location:connexion.php');
			}
			elseif ($user->inscription($_POST['login'], $_POST["password"], $_POST['confPassword'], $bdd) == "userExist") 
			{
				echo "ce login existe";
			}
			elseif ($user->inscription($_POST['login'], $_POST["password"], $_POST['confPassword'], $bdd) == "mdpFaux") 
			{
				echo "mot de passe !=";
			}
			elseif ($user->inscription($_POST['login'], $_POST["password"], $_POST['confPassword'], $bdd) == "logVide") 
			{
				echo "champ manquant";
			}
		}
?>
	</main>

</body>
</html>

