<?php

	session_start();

	require 'class/bdd.php';
	require 'class/user.php';

	$user = new user();
	$bdd = new bdd();
	
	$bdd->connect();

?>


<!DOCTYPE html>
<html>
<head>
	<title>Commande</title>
</head>
<body>
	<main>
		LALAL
	</main>

</body>
</html>