<?php
	session_start();

	require 'class/bdd.php';
	require 'class/user.php';

	$user = new user();
	$bdd = new bdd();
	
	$bdd->connect();

	if ($_SESSION['login'] != 'admin') 
	{
		header('Location:index.php');
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>ADMIN</title>
</head>
<body>
	<main>
		Ajouter Plat<br />
		<form action="" method="post">
			
		</form>


		Modifier Plat<br />
		<form action="" method="post">
			
		</form>

		
		Liste Plat<br />
		
		Liste User<br />
		<?php

		$allUser = $bdd->execute("SELECT * FROM utilisateurs");
		var_dump($allUser);
		?>


	</main>

</body>
</html>