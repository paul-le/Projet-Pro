<?php

	session_start();

	require 'class/bdd.php';
	require 'class/user.php';

	$user = new user();
	$bdd = new bdd();
	
	$bdd->connect();

	if (isset($_SESSION['id'])) 
	{

		$showPanier = $bdd->execute("SELECT * FROM panier INNER JOIN plats ON panier.id_produit = plats.id INNER JOIN utilisateurs ON panier.id_utilisateur = utilisateurs.id WHERE id_utilisateur = '".$_SESSION['id']."'") ;
		var_dump($showPanier);
		
	}


?>


<!DOCTYPE html>
<html>
<head>
	<title>PANIER</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<main>
		<section>
			<form method="post" action="">
				<table>
					<thead>
						<tr>
							<?php
							if (isset($_SESSION['login']))
							{?>
								<td colspan="6">Panier de : <?php echo $_SESSION['login'] ?></td>
								
							<?php
							}
							?>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>Nom</td>
							<td>Photo</td>
							<td>Quantite</td>
							<td></td>
							<td>Prix</td>
							<td></td>
						</tr>

						<?php
							if (isset($_SESSION['id'])) 
							{
						
								$nbProduit = count($showPanier);
								if ($nbProduit == 0) 
								{
									echo "Votre Panier est vide";
								}
								else
								{
									$i = 0 ;
									$prixTotal = 0;
									while ($i != $nbProduit) 
									{

										$idProduit = $showPanier[$i][0];
										$idArticle = $showPanier[$i][1];
										?>
										<tr id="generationItemPanier">
											<td><?php echo $showPanier[$i][6]; ?></td>
											<td><img src="photoProduit/<?php echo $showPanier[$i][10] ?>" width ="100" ></td>
											<td><?php echo $showPanier[$i][3]; ?></td>
											<td>
												<select name="addQuantite<?php echo $showPanier[$i][0]; ?>">
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
												</select>
												<input type="submit" name="newAdd<?php echo $showPanier[$i][0]; ?>" value="Add">
											</td>
											<td><?php echo $showPanier[$i][4]; ?></td>

											<td>
												<input type="submit" name="deleteProduit<?php echo $showPanier[$i][0]; ?>" value="Supprimer">
											</td>
										</tr>

										<?php

										if (isset($_POST["newAdd$idProduit"])) 
										{
											
											$newQuantiteProduit = $showPanier[$i][3] + $_POST["addQuantite$idProduit"];
											$requeteUpdateQuantite = $bdd->executeonly("UPDATE panier set quantite = '".$newQuantiteProduit."' WHERE id = '$idProduit' ");
											

											$prixProduit = $showPanier[$i][9] * $_POST["addQuantite$idProduit"];
											$newPrixProduit = $showPanier[$i][4] + $prixProduit;

											$newPrix = $bdd->executeonly("UPDATE panier set prix = '".$newPrixProduit."' WHERE id = '$idProduit'");
						
	
											header('Location:panier.php');

										}
										
										if (isset($_POST["deleteProduit$idProduit"])) 
										{
											
											$requeteDelete = $bdd->executeonly("DELETE FROM panier WHERE id = '$idProduit'");
											
											
											header('Location:panier.php');
										}



										
										$prixTotal += $showPanier[$i][4];

										$quantiteProduits = $showPanier[$i][3];
										$prixArticle = $showPanier[$i][4];
										
										
										
										$i++;
									}
									?>
									<tr>
										<td colspan="6"> <br> <b>Montant Total : <?php echo $prixTotal ; ?> € </b></td>
									</tr>
									<tr id="paiementButton">
										<td colspan="6"><a href="commande.php" target=" "><input type="submit" name="paiement" value="Commande"></a></td>
									</tr>

									<?php
								}

							}
							?>
					</tbody>
				</table>
			</form>
		</section>
	</main>

</body>
</html>