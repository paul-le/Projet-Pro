<?php
	session_start();

	require 'class/bdd.php';
	require 'class/user.php';
	require 'class/produits.php';

	$user = new user();
	$bdd = new bdd();
	$produit = new produits();
	
	$bdd->connect();

	$categorie = $bdd->execute("SELECT * FROM categorie");
	$nbCat = count($categorie);

	$plats = $bdd->execute("SELECT * FROM plats INNER JOIN categorie ON plats.id_categorie = categorie.id");
	$nbPlats = count($plats);




	

?>

<!DOCTYPE html>
<html>
<head>
	<title>ADMIN</title>
</head>
<body>
	<main>
		Ajouter Categorie<br />
		<form action="" method="post">
			Nom : <input type="text" name="nameCategorie">

			<input type="submit" name="newCategorie" value="Ajouter">
		</form>
		<?php
		if (isset($_POST['newCategorie'])) 
		{
			$nom = $_POST['nameCategorie'];
			if ($produit->addCategorie($nom, $bdd) == "newCategorie") 
			{
				echo "Categorie Ajouter";
				header('location:admin.php');
			}
			elseif ($produit->addCategorie($nom, $bdd) == "categorieExistante") 
			{
				echo "Cette Categorie existe deja";
			}
			elseif ($produit->addCategorie($nom, $bdd) == "info") 
			{
				echo "Veuillez entrer un nom ";
			}
		}

		?>
		<br /><br />

		Liste Categorie<br />
		<?php

		

		if (!empty($categorie)) 
		{
			for ($i=0; $i < $nbCat ; $i++) 
				{?> 
					<form method="post" action="">
						Categorie : <input type="text" name="upCat" placeholder="<?php echo $categorie[$i][1]; ?>">
						<input id="buttonAdmin" type="submit" name="updateCategorie<?php echo $categorie[$i][0]; ?>" value="Modifier">
						<input id="buttonAdmin" type="submit" name="deleteCategorie<?php echo $categorie[$i][0]; ?>" value="Supprimer">
						<br><br>
					</form>
					<?php

					$idCat = $categorie[$i][0];
					$nomCat = $categorie[$i][1];

					if (isset($_POST["updateCategorie$idCat"]) AND strlen($_POST['upCat']) != 0) 
					{

						$nameCategorie = $bdd->execute("SELECT nom FROM categorie WHERE nom = '".$_POST['upCat']."' ");
						if (empty($nameCategorie)) 
						{
							$requeteUpdateCat = $bdd->executeonly("UPDATE categorie set nom = '".$_POST['upCat']."' WHERE nom = '".$nomCat."' ");
							header('location:admin.php');
						}
						else
						{
							echo "Ce nom existe";
						}
						

						
					}
					if (isset($_POST["deleteCategorie$idCat"])) 
					{
						$requeteDeleteCat = $bdd->executeonly("DELETE FROM categorie WHERE id = '".$idCat."'");
						
						header('location:admin.php');

					}
				}
		}
		else
		{
			echo "PAS DE CATEGORIE";
		}
		?>
		<br /><br />



		Ajouter Plat<br /><br />

		<form action="" method="post" enctype="multipart/form-data">
			Nom : <input type="text" name="nameProduit" required><br /><br />

			Description : <input type="textarea" name="descriptionProduit" required><br /><br />

			Prix : <input type="number" step="0.01" name="prixProduit" required><br /><br />

			IMG : <input type="file" name="imgProduit" required><br /><br />


			Viande :  OUI <input type="radio" name="viande" value="oui">
					  NON <input type="radio" name="viande" value="non">
					 <br /><br />


			Categorie : <select type='post' name="categorie">
							<?php
							for ($i  =0; $i < $nbCat; $i++) 
							{?> 
								<option><?php echo $categorie[$i][1]; ?></option>
							<?php
							}

							?>

						</select>
						<br /><br />
			<input type="submit" name="addProduits" value="Ajouter">
					
		</form>

		<?php

		if (isset($_POST['addProduits'])) 
		{
			

			$nom = $_POST['nameProduit'];
			$description = $_POST['descriptionProduit'];
			$prix = $_POST['prixProduit'];

			$id_categorie = $bdd->executeassoc("SELECT * FROM categorie WHERE nom = '".$_POST['categorie']."' ");

			
			$viande = $_POST['viande'] ;
			

			
		
			if (isset($_FILES['imgProduit']) AND !empty($_FILES['imgProduit'])) 
			{

				$tailleMax = 2097152 ;
				$extensionsValides = $arrayName = array('jpg', 'jpeg', 'png');
				if ($_FILES['imgProduit']['size'] <= $tailleMax) 
				{

					$extensionsUpload = strtolower(substr(strrchr($_FILES['imgProduit']['name'], '.'), 1));
					if (in_array($extensionsUpload, $extensionsValides)) 
					{
						$chemin = "photoProduit/".$_POST['nameProduit'].".".$extensionsUpload;

						$deplacement = move_uploaded_file($_FILES['imgProduit']['tmp_name'], $chemin);

						if ($deplacement) 
						{
							$img = $_POST['nameProduit'].".".$extensionsUpload;
						}
						else
						{
							echo "Erreur durant l'importation de votre photo de profil" ;
						}
					}
					else
					{
						echo "Votre photo de profil doit être au format jpg, jpeg ou png. ";
					}

				}
				else
				{
					echo "Votre photo de profil ne doit pas dépasser 2Mo" ;
				}
			}



			if (!empty($img)) 
			{
				if ($produit->addProduit($nom, $description, $prix, $id_categorie[0]['id'], $img, $viande, $bdd) == "newProduit") 
				{
					echo "PRODUIT AJOUTER";
				}
				elseif ($produit->addProduit($nom, $description, $prix, $id_categorie[0]['id'], $img, $viande, $bdd) == "produitExist") 
				{
					echo "CE PRODUIT EXISTE";
				}
				elseif ($produit->addProduit($nom, $description, $prix, $id_categorie[0]['id'], $img, $viande, $bdd) == "info") 
				{
					echo "Veuillez remplir tout les champ";
				}
			}
			


			
		}

		?>

		<br/>
		
		Liste Plat<br /><br />
		<form method="post" action="" enctype="multipart/form-data">
			
			<table>
				<thead>
					<tr>
						<th colspan="6">Liste des plats</th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td>Nom</td>
						<td>Description</td>
						<td>Prix</td>
						<td>Categorie</td>
						<td>Photo</td>
						<td>Viande</td>
						<td></td>
						<td></td>
					</tr>
					<?php 
					for ($i = 0; $i < $nbPlats ; $i ++) 
						{?>
							<tr>
								<td><?php echo $plats[$i][1];  ?></td>
								<td><?php echo $plats[$i][2];  ?></td>
								<td><?php echo $plats[$i][4];  ?></td>
								<td><?php echo $plats[$i][8];  ?></td>
								<td><img src="photoProduit/<?php echo $plats[$i][5] ?>" width="100"></td>
								<td><?php echo $plats[$i][6];  ?></td>
								<td><input type="submit" name="modifierProduit<?php echo $plats[$i][0]; ?>" value="Modifier" ></td>
								<td><input type="submit" name="deleteProduit<?php echo $plats[$i][0];  ?>" value="Supprimer" ></td>
							</tr>
								<?php

								$idProduits = $plats[$i][0];
								$updateProduit = $bdd->execute("SELECT * FROM plats INNER JOIN categorie ON plats.id_categorie = categorie.id WHERE plats.id = '$idProduits'");


								
								
								if (isset($_POST["deleteProduit$idProduits"])) 
								{
									$delete = $bdd->executeonly("DELETE FROM plats WHERE id = '$idProduits'");
									header('location:admin.php');
								
								}

								if (isset($_POST["modifierProduit$idProduits"])) 
								{	
									

									
									?>
									<input type="text" name="id" placeholder="<?php echo $updateProduit[0][0];  ?>">
									<input type="text" name="updateNameProduit" placeholder="<?php echo $updateProduit[0][1];  ?>">
									<input type="textarea" name="updateDescriptionProduit" placeholder="<?php echo $updateProduit[0][2];  ?>">
									<input type="number" step="0.01" name="updatePrixProduit" placeholder="<?php echo $updateProduit[0][4];  ?>">
									
									<input type="file" name="updateImgProduit">
									Viande :  OUI <input type="radio" name="updateViandeProduit" value="oui">
											  NON <input type="radio" name="updateViandeProduit" value="non">
					  				
									<input type="submit" name="modifier2Produit<?php echo $updateProduit[0][0]; ?>" value="Modifier" >						


									
								<?php
								}

								$id = $updateProduit[0][0] ;
								if (isset($_POST["modifier2Produit$id"])) 
								{
									
									$updateNom = $_POST['updateNameProduit'];
									$updateDescription = $_POST['updateDescriptionProduit'];
									$updatePrix = $_POST['updatePrixProduit'];
									$updateViande = $_POST['updateViandeProduit'] ;
									
									

									if (!empty($_FILES['updateImgProduit']))
									{

										$tailleMax = 2097152 ;
										$extensionsValides = $arrayName = array('jpg', 'jpeg', 'png');
										if ($_FILES['updateImgProduit']['size'] <= $tailleMax) 
										{

											$extensionsUpload = strtolower(substr(strrchr($_FILES['updateImgProduit']['name'], '.'), 1));
											if (in_array($extensionsUpload, $extensionsValides)) 
											{
												if (!empty($updateNom)) 
													{
														
														$chemin = "photoProduit/".$_POST['updateNameProduit'].".".$extensionsUpload;
													}
													else
													{
														
														$chemin = "photoProduit/".$updateProduit[0][1].".".$extensionsUpload;
													}



												$deplacement = move_uploaded_file($_FILES['updateImgProduit']['tmp_name'], $chemin);

												if ($deplacement) 
												{
													if (!empty($updateNom))
													{
														$updateImg = $_POST['updateNameProduit'].".".$extensionsUpload;
													}
													else
													{
														$updateImg = $updateProduit[0][1].".".$extensionsUpload;
													}

												}
												else
												{
													echo "Erreur durant l'importation de votre photo de profil" ;
												}
											}
											else
											{
												echo "Votre photo de profil doit être au format jpg, jpeg ou png. ";
											}

										}
										else
										{
											echo "Votre photo de profil ne doit pas dépasser 2Mo" ;
										}
									}
									else
									{
										
										$updateImg = $updateProduit[0][5];	
										
									}

									
									

									
									
									
										
										if ($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $updateImg, $updateViande, $id, $bdd) == "nameChange") 
										{
											echo "Le nom a changer";
										}

										if ($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $updateImg, $updateViande, $id, $bdd) == "descriptionChange") 
										{
											echo "La description a changer";
										}

										if ($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $updateImg, $updateViande, $id, $bdd) == "prixChange") 
										{
											echo "Le prix a changer";
										}

										if ($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $updateImg, $updateViande, $id, $bdd) == "imgChange") 
										{
											echo "La photo a changer";
										}

										if ($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $updateImg, $updateViande, $id, $bdd) == "viandeChange") 
										{
											echo "La viande a changer";
										}
									
										
									

									


									
								}
								
							?>
							
							<?php
						}
						?>

					</tbody>
				</table>

		</form>

		
		
		
		Liste User<br />
		<?php

		$allUser = $bdd->execute("SELECT * FROM utilisateurs");

		
		?>


	</main>

</body>
</html>