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

		<h2>VOS GOUT :</h2>
		Proteines :<br />
		<form method="post" action="">
			<button type="submit" style="background-image: url(img/proteine/boeuf.jpg); background-size: cover;">Boeuf</button>

			<button style="background-image: url(img/proteine/poulet.jpeg); background-size: cover;">Poulet</button>

			<button style="background-image: url(img/proteine/dinde.jpg); background-size: cover;">Dinde</button>

			<button id="saumon" type="submit" style="background-image: url(img/proteine/saumon.jpg); background-size: cover;">Saumon</button>

			<button style="background-image: url(img/proteine/thon.jpg); background-size: cover;">Thon</button>

			<button>Calamar</button>
			<br />
			<br />

			Légumes :<br />

			<button>Haricot vert / rouge</button>

			<button style="background-image: url(img/legumes/pommeDeTerre.jpg); background-size: cover;">Pommes de terre</button>

			<button style="background-image: url(img/legumes/brocolis.jpg); background-size: cover;">Brocolis</button>

			<button style="background-image: url(img/legumes/avocat.jpg); background-size: cover;">Avocat</button>

			<button style="background-image: url(img/legumes/choux.jpg); background-size: cover;">Choux</button>

			<button style="background-image: url(img/legumes/salade.jpg); background-size: cover;">Salade</button>


			<button style="background-image: url(img/legumes/poivrons.jpg); background-size: cover;">Poivrons</button>

			<button style="background-image: url(img/legumes/champignon.jpg); background-size: cover;">Champignons</button>

			<button style="background-image: url(img/legumes/lentilles.jpg); background-size: cover;">Lentilles</button>

			<br />
			<br />
			<input type="submit" name="addInfoUser" value="Enregistrer">
		</form>
		
		

	</main>
<script type="text/javascript" src="js.questionProfil.js"></script>
</body>
</html>