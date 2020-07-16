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

$ingredients = $bdd->execute("SELECT * FROM ingredients");
$nbIngredients = count($ingredients);

$plats = $bdd->execute("SELECT * FROM plats INNER JOIN categorie ON plats.id_categorie = categorie.id");
$nbPlats = count($plats);
var_dump($plats);
ob_start(); 




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
					Ajouter Categorie / Ingredient
				</div>

				
				<form action="" method="post">

					Categorie :<br /> <input type="text" name="nameCategorie"><br />

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

				<form action="" method="post">

					Ingredient :<br /> <input type="text" name="nameIngredient"><br />

					<input type="submit" name="newIngredient" value="Ajouter">
				</form>
				<?php
				if (isset($_POST['newIngredient'])) 
				{
					$nom = $_POST['nameIngredient'];
					if ($produit->addIngredient($nom, $bdd) == "newIngredient") 
					{
						echo "Ingredient Ajouter";
						header('location:admin.php');
					}
					elseif ($produit->addIngredient($nom, $bdd) == "ingredientExistant") 
					{
						echo "Cet ingredient existe deja";
					}
					elseif ($produit->addIngredient($nom, $bdd) == "info") 
					{
						echo "Veuillez entrer un nom ";
					}
				}

				?>


				<br />



				<div id="titreListeCategorie">
					Liste Categorie & Ingredients
				</div>
				<section id="listeCatIng">
					
					<div id="listeCategorie">

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
								echo "Aucune Categorie";
							}
							?>
						</div>

						<div id="listeIngredient">

							<?php
							if (!empty($ingredients)) 
							{
								for ($i=0; $i < $nbIngredients ; $i++) 
									{?> 
										<form method="post" action="">
											Ingredient :<br /> <input type="text" name="upIngredients" placeholder="<?php echo $ingredients[$i][1]; ?>"><br />
											<input id="buttonAdmin" type="submit" name="updateIngredients<?php echo $ingredients[$i][0]; ?>" value="Modifier">
											<input id="buttonAdmin" type="submit" name="deleteIngredients<?php echo $ingredients[$i][0]; ?>" value="Supprimer">
											<br><br>
										</form>
										<?php

										$idIngredients = $ingredients[$i][0];
										$nomIngredients = $ingredients[$i][1];

										if (isset($_POST["updateIngredients$idIngredients"]) AND strlen($_POST['upIngredients']) != 0) 
										{

											$nameIngredient = $bdd->execute("SELECT nom FROM ingredients WHERE nom = '".$_POST['upIngredients']."' ");
											if (empty($nameIngredient)) 
											{
												$requeteUpdateIngredients = $bdd->executeonly("UPDATE ingredients set nom = '".$_POST['upIngredients']."' WHERE nom = '".$nomIngredients."' ");
												header('location:admin.php');
											}
											else
											{
												echo "Ce nom existe";
											}



										}
										if (isset($_POST["deleteIngredients$idIngredients"])) 
										{
											$requeteDeleteCat = $bdd->executeonly("DELETE FROM ingredients WHERE id = '".$idIngredients."'");

											header('location:admin.php');

										}
									}
								}
								else
								{
									echo "Aucun ingredient";
								}


								?>
							</div>
				</section>
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

						IMG 1 : <br /><input type="file" name="img1Produit" required><br /><br />

						IMG 2 :<br /><input type="file" name="img2Produit" required><br /><br />


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



							




							if (isset($_FILES['img1Produit']) AND !empty($_FILES['img1Produit'])) 
							{

								$tailleMax = 2097152 ;
								$extensionsValides = $arrayName = array('jpg', 'jpeg', 'png');
								if ($_FILES['img1Produit']['size'] <= $tailleMax) 
								{

									$extensionsUpload = strtolower(substr(strrchr($_FILES['img1Produit']['name'], '.'), 1));
									if (in_array($extensionsUpload, $extensionsValides)) 
									{
										$chemin = "photoProduit/".$_POST['nameProduit']."1.".$extensionsUpload;

										$deplacement = move_uploaded_file($_FILES['img1Produit']['tmp_name'], $chemin);

										if ($deplacement) 
										{
											$img1 = $_POST['nameProduit']."1.".$extensionsUpload;
										}
										else
										{
											echo "Erreur durant l'importation de votre photo de profil (1)" ;
										}
									}
									else
									{
										echo "Votre photo de profil doit être au format jpg, jpeg ou png. (1) ";
									}

								}
								else
								{
									echo "Votre photo de profil ne doit pas dépasser 2Mo (1)" ;
								}
							}

							if (isset($_FILES['img2Produit']) AND !empty($_FILES['img2Produit'])) 
							{

								$tailleMax = 2097152 ;
								$extensionsValides = $arrayName = array('jpg', 'jpeg', 'png');
								if ($_FILES['img2Produit']['size'] <= $tailleMax) 
								{

									$extensionsUpload = strtolower(substr(strrchr($_FILES['img2Produit']['name'], '.'), 1));
									if (in_array($extensionsUpload, $extensionsValides)) 
									{
										$chemin = "photoProduit/".$_POST['nameProduit']."2.".$extensionsUpload;

										$deplacement = move_uploaded_file($_FILES['img2Produit']['tmp_name'], $chemin);

										if ($deplacement) 
										{
											$img2 = $_POST['nameProduit']."2.".$extensionsUpload;
										}
										else
										{
											echo "Erreur durant l'importation de votre photo de profil (2)" ;
										}
									}
									else
									{
										echo "Votre photo de profil doit être au format jpg, jpeg ou png. (2) ";
									}

								}
								else
								{
									echo "Votre photo de profil ne doit pas dépasser 2Mo  (2)" ;
								}
							}


							
							if (!empty($img1) && !empty($img2)) 
							{
								if ($produit->addProduit($nom, $description, $prix, $id_categorie[0]['id'], $img1, $img2, $bdd) == "newProduit") 
								{
									echo "PRODUIT AJOUTER";
								}
								elseif ($produit->addProduit($nom, $description, $prix, $id_categorie[0]['id'], $img1, $img2, $bdd) == "produitExist") 
								{
									echo "CE NOM EXISTE";
								}
								elseif ($produit->addProduit($nom, $description, $prix, $id_categorie[0]['id'], $img1, $img2, $bdd) == "info") 
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
									<td>IMG 1</td>
									<td>IMG 2</td>
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
											<td  data-title="Photo1"><img src="photoProduit/<?php echo $plats[$i][5] ?>" width="100"></td>
											<td  data-title="Photo2"><img src="photoProduit/<?php echo $plats[$i][6] ?>" width="100"></td>
											<td><input type="submit" name="modifierProduit<?php echo $plats[$i][0]; ?>" value="Modifier" ></td>
											<td><input type="submit" name="deleteProduit<?php echo $plats[$i][0];  ?>" value="Supprimer" ></td>
										</tr>
										<?php

										$idProduits = $plats[$i][0];
										$updateProduit = $bdd->execute("SELECT * FROM plats INNER JOIN categorie ON plats.id_categorie = categorie.id WHERE plats.id = '$idProduits'");


										var_dump($updateProduit);

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
											<input type="file" name="updateImg1Produit">
											<input type="file" name="updateImg2Produit">

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
												

												if (empty($id_categorieUpdate)) 
												{
													$id_categorieUpdate = $updateProduit[0][4];
												}


												

												


												if ($_FILES['updateImg1Produit']['size'] == 0 && $_FILES['updateImg1Produit']['error'] == 0)
												{

													$tailleMax = 2097152 ;
													$extensionsValides = $arrayName = array('jpg', 'jpeg', 'png');
													if ($_FILES['updateImg1Produit']['size'] <= $tailleMax) 
													{

														$extensionsUpload = strtolower(substr(strrchr($_FILES['updateImg1Produit']['name'], '.'), 1));
														if (in_array($extensionsUpload, $extensionsValides)) 
														{
															if (!empty($updateNom)) 
															{

																$chemin = "photoProduit/".$_POST['updateNameProduit']."1.".$extensionsUpload;
															}
															else
															{

																$chemin = "photoProduit/".$updateProduit[0][1].".".$extensionsUpload;
															}



															$deplacement = move_uploaded_file($_FILES['updateImg1Produit']['tmp_name'], $chemin);

															if ($deplacement) 
															{
																if (!empty($updateNom))
																{
																	$updateImg1 = $_POST['updateNameProduit']."1.".$extensionsUpload;
																}
																else
																{
																	$updateImg1 = $updateProduit[0][1].".".$extensionsUpload;
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
													$updateImg1 = $updateProduit[0][5];										
												}


												if ($_FILES['updateImg2Produit']['size'] == 0 && $_FILES['updateImg2Produit']['error'] == 0)
												{

													$tailleMax = 2097152 ;
													$extensionsValides = $arrayName = array('jpg', 'jpeg', 'png');
													if ($_FILES['updateImg2Produit']['size'] <= $tailleMax) 
													{

														$extensionsUpload = strtolower(substr(strrchr($_FILES['updateImg2Produit']['name'], '.'), 1));
														if (in_array($extensionsUpload, $extensionsValides)) 
														{
															if (!empty($updateNom)) 
															{

																$chemin = "photoProduit/".$_POST['updateNameProduit']."2.".$extensionsUpload;
															}
															else
															{

																$chemin = "photoProduit/".$updateProduit[0][1].".".$extensionsUpload;
															}



															$deplacement = move_uploaded_file($_FILES['updateImg2Produit']['tmp_name'], $chemin);

															if ($deplacement) 
															{
																if (!empty($updateNom))
																{
																	$updateImg2 = $_POST['updateNameProduit']."2.".$extensionsUpload;
																}
																else
																{
																	$updateImg2 = $updateProduit[0][1].".".$extensionsUpload;
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
													$updateImg2 = $updateProduit[0][6];										
												}



												$nameProduit = $bdd->execute("SELECT nom FROM plats WHERE nom = '$updateNom'");


												if (!empty($nameProduit)) 
												{
													echo "Ce nom de plats existe";
												}
												elseif($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $id_categorieUpdate[0][0] , $updateImg1, $updateImg2, $id, $bdd) == "nameChange") 
												{
													echo "Le nom a changer";
												}

												if ($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $id_categorieUpdate[0][0], $updateImg1, $updateImg2, $id, $bdd) == "descriptionChange") 
												{
													echo "La description a changer";
												}

												if ($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $id_categorieUpdate[0][0], $updateImg1, $updateImg2, $id, $bdd) == "prixChange") 
												{
													echo "Le prix a changer";
												}

												if ($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $id_categorieUpdate[0][0], $updateImg1, $updateImg2, $id, $bdd) == "updateChange") 
												{
													echo "La Categorie a changer";
												}

												if ($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $id_categorieUpdate[0][0], $updateImg1, $updateImg2, $id, $bdd) == "img1Change") 
												{
													echo "La photo1 a changer";
												}

												if ($produit->updateProduits($updateNom, $updateDescription, $updatePrix, $id_categorieUpdate[0][0], $updateImg1, $updateImg2, $id, $bdd) == "img2Change") 
												{
													echo "La photo2 a changer";
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

<?php
ob_end_flush(); 
?>