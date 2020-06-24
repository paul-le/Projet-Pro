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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
	<main>
		

		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
			Modifier information  ?
		</button> 

		<!-- Modal -->
		<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Modification mot de passe</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form method="post" action="">

						<div class="modal-body">
							
							<label>Login</label> : <input type="text" name="updateLogin" placeholder="<?php echo $user[0][1]; ?>"><br />
							<label>Mot de passe</label>   : <input type="password" name="updatePassword"><br />
							<label>Confirmation mot de passe</label>  : <input type="password" name="updateConfPassword">
						
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<!-- <button type="button" class="btn btn-primary" name="updateInfo">Save changes</button> -->
							<input type="submit" class="btn btn-primary" name="updateInfo">

						</div>
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

								}
								elseif (empty($login) && !empty($loginUpdate)) 
								{
									
									$updateLogin = $bdd->executeonly("UPDATE utilisateurs SET login = '$loginUpdate' WHERE id= '$id'");
									
									  
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

					</form>
				</div>
			</div>
		</div> 
					
				</div>
			</div>
		</div>
	</main>

</body>
</html>