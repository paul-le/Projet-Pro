<?php

session_start();
require 'class/bdd.php';
require 'class/user.php';

$user = new user();
$bdd = new bdd();

$bdd->connect();

$userInfo = $bdd->execute("SELECT * FROM utilisateurs WHERE id = '".$_SESSION['id']."' ");


var_dump($userInfo);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Profil</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="css/style.css">


</head>
<body>
	<main>
		<div id="profil">
			
			<form method="post" action="">

				<div>

					<label>Login</label> : <input type="text" name="updateLogin" placeholder="<?php echo $userInfo[0][1]; ?>"><br />
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

		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
			Launch demo modal
		</button>

		<!-- Modal -->
		<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="height: 10px;">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<section id="preference">
							<form action="" method="post">
								<h2>VOS GOUT :</h2>
								-Proteines :<br />

								<section id="proteines">
									<div class="choice" id="boeuf">
										<input id="boeuf" type="checkbox" name="boeuf" value="boeuf" />
										<label for="boeuf">Boeuf</label>
									</div>

									<div class="choice" id="poulet">
										<input id="poulet" type="checkbox" name="poulet" value="poulet" />
										<label for="poulet">Poulet</label>
									</div>


									<div class="choice" id="dinde">    
										<input id="dinde" type="checkbox" name="dinde" value="dinde" />
										<label for="dinde">Dinde</label>
									</div>

									<div class="choice" id="saumon">
										<input id="saumon" type="checkbox" name="saumon" value="saumon" />
										<label for="saumon">Saumon</label>
									</div>

									<div class="choice" id="thon">
										<input id="thon" type="checkbox" name="thon" value="thon" />
										<label for="thon">Thon</label>
									</div>


									<div class="choice" id="calamar">    
										<input id="calamar" type="checkbox" name="calamar" value="calamar" />
										<label for="calamar">Calamar</label>
									</div>

								</section>


								-Légumes : 
								<section id="legumes">
									<div class="choice" id="haricots">
										<input id="haricots" type="checkbox" name="haricots" value="haricots" />
										<label for="haricots">Haricots Vert/Rouge</label>
									</div>

									<div class="choice" id="pommeDeTerre">
										<input id="pommeDeTerre" type="checkbox" name="pommeDeTerre" value="pommeDeTerre" />
										<label for="pommeDeTerre">Pomme de terre</label>
									</div>


									<div class="choice" id="brocolis">    
										<input id="brocolis" type="checkbox" name="brocolis" value="brocolis" />
										<label for="brocolis">Brocolis</label>
									</div>

									<div class="choice" id="avocat">
										<input id="avocat" type="checkbox" name="avocat" value="avocat" />
										<label for="avocat">Avocat</label>
									</div>

									<div class="choice" id="choux">
										<input id="choux" type="checkbox" name="choux" value="choux" />
										<label for="choux">Choux</label>
									</div>


									<div class="choice" id="salade">    
										<input id="salade" type="checkbox" name="salade" value="salade" />
										<label for="salade">Salade</label>
									</div>

									<div class="choice" id="poivrons">
										<input id="poivrons" type="checkbox" name="poivrons" value="poivrons" />
										<label for="poivrons">Poivrons</label>
									</div>

									<div class="choice" id="champignons">
										<input id="champignons" type="checkbox" name="champignons" value="champignons" />
										<label for="champignons">Champignon</label>
									</div>

									<div class="choice" id="lentilles">
										<input id="lentilles" type="checkbox" name="lentilles" value="lentilles" />
										<label for="lentilles">Lentilles</label>
									</div>

								</section>



							</form>
						</section>
						


					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-primary" name="preference" value="Enregistrer">

						<?php
						if (isset($_POST["preference"])) 
						{
							if (isset($_POST["boeuf"])) 
							{
								$boeuf = $_POST["boeuf"] ;
								$boeuf = 1;
							}
							else
							{
								$boeuf = 0 ;
							}

							if (isset($_POST["poulet"]))
							{
								$poulet = $_POST["poulet"] ;
								$poulet = 1;
							}
							else
							{
								$poulet = 0 ;
							}

							if (isset($_POST["dinde"])) 
							{
								$dinde = $_POST["dinde"] ;
								$dinde = 1;

							}
							else
							{
								$dinde = 0 ;
							}

							if (isset($_POST["saumon"])) 
							{
								$saumon = $_POST["saumon"] ;
								$saumon = 1;
							}
							else
							{
								$saumon = 0 ;
							}

							if (isset($_POST["thon"]))
							{
								$thon = $_POST["thon"] ;
								$thon = 1;
							}
							else
							{
								$thon = 0 ;
							}

							if (isset($_POST["calamar"]))
							{
								$calamar = $_POST["calamar"] ;
								$calamar = 1;
							}
							else
							{
								$calamar = 0 ;
							}

							if (isset($_POST["haricots"])) 
							{
								$haricots = $_POST["haricots"] ;
								$haricots = 1;
							}
							else
							{
								$haricots = 0 ;
							}

							if (isset($_POST["pommeDeTerre"]))
							{
								$pommeDeTerre = $_POST["pommeDeTerre"] ;
								$pommeDeTerre = 1;
							}
							else
							{
								$pommeDeTerre = 0 ;
							}

							if (isset($_POST["brocolis"]))
							{
								$brocolis = $_POST["brocolis"] ;
								$brocolis = 1;
							}
							else
							{
								$brocolis = 0 ;
							}

							if (isset($_POST["avocat"])) 
							{
								$avocat = $_POST["avocat"] ;
								$avocat = 1;
							}
							else
							{
								$avocat = 0 ;
							}

							if (isset($_POST["choux"]))
							{
								$choux = $_POST["choux"] ;
								$choux = 1;
							}
							else
							{
								$choux = 0 ;
							}

							if (isset($_POST["salade"]))
							{
								$salade = $_POST["salade"] ;
								$salade = 1;
							}
							else
							{
								$salade = 0 ;
							}

							if (isset($_POST["poivrons"]))
							{
								$poivrons = $_POST["poivrons"] ;
								$poivrons = 1;
							}
							else
							{
								$poivrons = 0 ;
							}

							if (isset($_POST["champignons"]))
							{
								$champignons = $_POST["champignons"] ;
								$champignons = 1;
							}
							else
							{
								$champignons = 0 ;
							}

							if (isset($_POST["lentilles"]))
							{
								$lentilles = $_POST["lentilles"] ;
								$lentilles = 1;
							}
							else
							{
								$lentilles = 0 ;
							}

							$user->addPreferenceGout($userInfo[0][0], $boeuf, $poulet, $dinde, $saumon, $thon, $calamar, $haricots, $pommeDeTerre, $brocolis, $avocat, $choux, $salade, $poivrons, $champignons, $lentilles, $bdd);

							
						}
						?>
					</div>
				</div>
			</div>
		</div>

		
	
	</main>
	<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="js/profil.js"></script>
	
</body>
</html>