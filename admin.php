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
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</head>
<body id="bodyAdmin" >
	
	<main id="mainAdmin" class="container-fluid">
		<section id="categorieAndPlat" >
			
			<section id="addCategorie">
				<div id="titreAddCategorie">
					Ajouter Categorie
				</div>

				
				<form action="" method="post">

					Nom :<br /> <input type="text" name="nameCategorie"><br />

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


				<br />



				<div id="titreListeCategorie">
					Liste Categorie
				</div>
				
				<?php



				if (!empty($categorie)) 
				{
					for ($i=0; $i < $nbCat ; $i++) 
						{?> 
							<form method="post" action="">
								Categorie :<br /> <input type="text" name="upCat" placeholder="<?php echo $categorie[$i][1]; ?>"><br />
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
				</section>




				<br /><br />

				<section id="addPlat">
					<div id="titreListeCategorie">
						Ajouter Plat
					</div>

					<form action="" method="post" enctype="multipart/form-data">
						Nom : <br /><input type="text" name="nameProduit" required><br /><br />

						Description : <br /><input type="textarea" name="descriptionProduit" required><br /><br />

						Prix :<br /> <input type="number" step="0.01" name="prixProduit" required><br /><br />

						IMG : <br /><input type="file" name="imgProduit" required><br /><br />


						Viande :  OUI <input type="radio" name="viande" value="oui">
						NON <input type="radio" name="viande" value="non">
						<br /><br />


						Categorie : <br /><select type='post' name="categorie">
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
									echo "CE NOM EXISTE";
								}
								elseif ($produit->addProduit($nom, $description, $prix, $id_categorie[0]['id'], $img, $viande, $bdd) == "info") 
								{
									echo "Veuillez remplir tout les champ";
								}
							}




						}

						?>
					</section>



				</section>



				<br/>
				<div id="listePlat">
					LISTE DES PLATS
				</div>
				<section id="no-more-tables">
					
					<form method="post" action="" enctype="multipart/form-data">

						<table class="col-md-12 table-bordered table-striped table-condensed cf">
							<thead class="cf">
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
							</thead>

							<tbody>
								
								<?php 
								for ($i = 0; $i < $nbPlats ; $i ++) 
									{?>
										<tr>
											<td data-title="Nom"><?php echo $plats[$i][1];  ?></td>
											<td data-title="Description"><?php echo $plats[$i][2];  ?></td>
											<td  data-title="Prix" class="numeric"><?php echo $plats[$i][4];  ?></td>
											<td  data-title="Categorie"><?php echo $plats[$i][8];  ?></td>
											<td  data-title="Photo"><img src="photoProduit/<?php echo $plats[$i][5] ?>" width="100"></td>
											<td  data-title="Viande"><?php echo $plats[$i][6];  ?></td>
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

											<input type="text" name="updateNameProduit" placeholder="<?php echo $updateProduit[0][1];  ?>">
											<input type="textarea" name="updateDescriptionProduit" placeholder="<?php echo $updateProduit[0][2];  ?>">
											<input type="number" step="0.01" name="updatePrixProduit" placeholder="<?php echo $updateProduit[0][4];  ?>">
											Categorie : <select type='post' name="updateCategorie">
												<option>.....</option>
												<?php
												for ($i  =0; $i < $nbCat; $i++) 
													{?> 
														<option><?php echo $categorie[$i][1]; ?></option>
														<?php
													}

													?>

												</select>
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
												$updateCategorie = $_POST['updateCategorie'];


												$id_categorieUpdate = $bdd->execute("SELECT * FROM categorie WHERE nom = '".$_POST['updateCategorie']."' ");
												var_dump($id_categorieUpdate);

												if (empty($id_categorieUpdate)) 
												{
													$id_categorieUpdate = $updateProduit[0][3];
												}


												if (!empty($_POST['updateViandeProduit'])) 
												{
													$updateViande = $_POST['updateViandeProduit'];
												}
												else
												{
													$updateViande = $updateProduit[0][6];
												}




												if ($_FILES['updateImgProduit']['size'] == 0 && $_FILES['updateImgProduit']['error'] == 0)
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





												$nameProduit = $bdd->execute("SELECT nom FROM plats WHERE nom = '$updateNom'");


												if (!empty($nameProduit)) 
												{
													echo "Ce nom de plats existe";
												}
												elseif($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $id_categorieUpdate[0][0] , $updateImg, $updateViande, $id, $bdd) == "nameChange") 
												{
													echo "Le nom a changer";
												}

												if ($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $id_categorieUpdate[0][0], $updateImg, $updateViande, $id, $bdd) == "descriptionChange") 
												{
													echo "La description a changer";
												}

												if ($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $id_categorieUpdate[0][0], $updateImg, $updateViande, $id, $bdd) == "prixChange") 
												{
													echo "Le prix a changer";
												}

												if ($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $id_categorieUpdate[0][0], $updateImg, $updateViande, $id, $bdd) == "updateChange") 
												{
													echo "La Categorie a changer";
												}

												if ($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $id_categorieUpdate[0][0], $updateImg, $updateViande, $id, $bdd) == "imgChange") 
												{
													echo "La photo a changer";
												}

												if ($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $id_categorieUpdate[0][0], $updateImg, $updateViande, $id, $bdd) == "viandeChange") 
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
				</section>

				




						Liste User<br />
						<?php

						$allUser = $bdd->execute("SELECT * FROM utilisateurs");


						?>


					</main>

				</body>
				</html>