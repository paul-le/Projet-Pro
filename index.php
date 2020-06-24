<?php

	session_start();
	var_dump($_SESSION['id']);
	var_dump($_SESSION['login']);

	require 'class/bdd.php';
	require 'class/user.php';

	$user = new user();
	$bdd = new bdd();
	
	$bdd->connect();
?>

<!DOCTYPE html>
<html>
<head>
	<title>INDEX</title>
</head>
<body>
	<main>
		<form action="" method="post">
			
			<input type="submit" value="DECO" name="deco">

		</form>
		<?php

		if (isset($_POST['deco'])) 
		{
			$user->disconnect();
		}
		?>
	</main>

</body>
</html>