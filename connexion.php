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
</head>
<body>
	<main>
		<form  action="" method="post">
        
            <label>Identifiant</label>
            <input type="text" name="login" required><br>
            <label>Mot de passe</label>
            <input type="password" name="password" required><br>

            <input type="submit" name="send">
        </form>

        <?php

        if(isset($_POST["send"]))
        {
        	$user->connexion($_POST["login"],$_POST["password"], $bdd);

        }

        ?>
	</main>

</body>
</html>