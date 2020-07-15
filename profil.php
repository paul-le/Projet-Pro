<?php

session_start();
require 'class/bdd.php';
require 'class/user.php';

$user = new user();
$bdd = new bdd();

$bdd->connect();

$user = $bdd->execute("SELECT * FROM utilisateurs WHERE id = '".$_SESSION['id']."' ");


var_dump($user);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Profil</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>


</head>
<body>
	<main>
		<div id="profil">
			
			<form method="post" action="">

				<div>

					<label>Login</label> : <input type="text" name="updateLogin" placeholder="<?php echo $user[0][1]; ?>"><br />
					<label>Mot de passe</label>   : <input type="password" name="updatePassword"><br />
					<label>Confirmation mot de passe</label>  : <input type="password" name="updateConfPassword">
					<br />
					<input type="submit" name="updateInfo" value="Modifier">

				</div>

				<div>

					<?php

					if (isset($_POST['updateInfo'])) 
					{
						$loginUpdate = $_POST['updateLogin'];
						$passwordUpdate = $_POST['updatePassword'];
						$updateConfPassword = $_POST['updateConfPassword'];


						$login = $bdd->execute("SELECT login FROM utilisateurs WHERE login = '$loginUpdate'");


						$id = $_SESSION['id'];


						if (!empty($loginUpdate) && !empty($login))             
						{                 
							echo "Ce Login est déjà prit"; 
							header("location:profil.php");

						}
						elseif (empty($login) && !empty($loginUpdate)) 
						{

							$updateLogin = $bdd->executeonly("UPDATE utilisateurs SET login = '$loginUpdate' WHERE id= '$id'");
							header("location:profil.php");

						}

						if(!empty($passwordUpdate))
						{
							if ($passwordUpdate == $updateConfPassword) 
							{
								$mdpHash = password_hash($passwordUpdate, PASSWORD_BCRYPT, array('cost' => 12));

								$updatePassword = $bdd->executeonly("UPDATE utilisateurs SET password ='$mdpHash' WHERE id = '$id' ");

							}
							else
							{
								echo "Les mots de passes sont différents !";
							}

						}

					}
					?>
				</div>

			</form>
		</div>

		<h2>Select an option (You will get it's value displayed in the text input field!)</h2>
		<form method="post" action="">
			<div class="radio-group">
				<div class='radio' data-value="One"></div>1
				<div class='radio' data-value="Two"></div>2
				<div class='radio' data-value="Three"></div>3
				<br/>
				<input type="text" id="radio-value" name="radio-value" />
			</div>

		</form>
	</main>
<script type="text/javascript" src="js.questionProfil.js"></script>
</body>
</html>