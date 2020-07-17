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
	<script type="text/javascript" src="js/userInfo.js"></script>


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

		<h2>VOS GOUT :</h2>
		Proteines :<br />
		<div class="choice" style="background-image: url(img/proteine/boeuf.jpg); background-size: cover; width: 50%;">
			<input id="choice_1" type="checkbox" name="choice_1" value="choice_1" />
			<label for="choice_1">Boeuf</label>
		</div>
		<form method="post" action="">
			<

			<input type=button class="buttonChoiceUserProfil" style="background-image: url(img/proteine/poulet.jpeg); background-size: cover;">Poulet</input>

			<input type=button class="buttonChoiceUserProfil" style="background-image: url(img/proteine/dinde.jpg); background-size: cover;">Dinde</input>

			<input type=button class="buttonChoiceUserProfil"  style="background-image: url(img/proteine/saumon.jpg); background-size: cover;">Saumon</input>

			<input type=button class="buttonChoiceUserProfil" style="background-image: url(img/proteine/thon.jpg); background-size: cover;">Thon</input>

			<input type=button class="buttonChoiceUserProfil">Calamar</input>
			<br />
			<br />

			Légumes :<br />

			<input type=button class="buttonChoiceUserProfil">Haricot vert / rouge</input>

			<input type=button class="buttonChoiceUserProfil" style="background-image: url(img/legumes/pommeDeTerre.jpg); background-size: cover;">Pommes de terre</input>

			<input type=button class="buttonChoiceUserProfil" style="background-image: url(img/legumes/brocolis.jpg); background-size: cover;">Brocolis</input>

			<input type=button class="buttonChoiceUserProfil" style="background-image: url(img/legumes/avocat.jpg); background-size: cover;">Avocat</input>

			<input type=button class="buttonChoiceUserProfil" style="background-image: url(img/legumes/choux.jpg); background-size: cover;">Choux</input>

			<input type=button class="buttonChoiceUserProfil" style="background-image: url(img/legumes/salade.jpg); background-size: cover;">Salade</input>


			<input type=button class="buttonChoiceUserProfil" style="background-image: url(img/legumes/poivrons.jpg); background-size: cover;">Poivrons</input>

			<input type=button class="buttonChoiceUserProfil" style="background-image: url(img/legumes/champignon.jpg); background-size: cover;">Champignons</input>

			<input type=button class="buttonChoiceUserProfil" style="background-image: url(img/legumes/lentilles.jpg); background-size: cover;">Lentilles</input>

			<br />
			<br />
			<?php
			


			?>
			<input type="submit" name="addInfoUser" value="Enregistrer">
		</form>
		
		

	</main>
	
</body>
</html>