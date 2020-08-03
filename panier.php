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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
</head>
<body>
	
	<main>
		<section>
			<form method="post" action="">
				<?php
				if (isset($_SESSION['login']))
					{?>
						<div id="nameUser">Panier de : <?php echo $_SESSION['login'] ?></div>

						<?php
					}
					?>
				<table id="tablePanier">
					
					<tbody>
						<tr>
							<td class="nameColumnProduit">Nom</td>
							<td class="nameColumnProduit">Photo</td>
							<td class="nameColumnProduit">Quantite</td>
							<td class="nameColumnProduit">Prix</td>
							<td></td>
						</tr>

						<?php
							if (isset($_SESSION['id'])) 
							{
						
								$nbProduit = count($showPanier);
								if ($nbProduit != 0) 
								{
									
									$i = 0 ;
									$prixTotal = 0;
									while ($i != $nbProduit) 
									{

										$idProduit = $showPanier[$i][0];
										
										?>
										<tr>
											<td class="nameColumnProduit"><?php echo $showPanier[$i][6]; ?></td>
											<td class="nameColumnProduit"><img src="photoProduit/<?php echo $showPanier[$i][10] ?>" width ="100" ></td>
											<td class="nameColumnProduit">
												
												<button style="font-size:15px" id="minus" name="minus<?php echo $showPanier[$i][0]; ?>" onclick="minusProduit()"><i class="fa fa-caret-square-o-left"></i></button>
												<?php echo $showPanier[$i][3]; ?>
												<button style="font-size:15px" id="plus" name="plus<?php echo $showPanier[$i][0]; ?>" onclick="plusProduit()"><i class="fa fa-caret-square-o-right"></i></button>
												
											</td>
											
											<td class="nameColumnProduit"><?php echo $showPanier[$i][4]; ?></td>

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


										if (isset($_POST["minus$idProduit"])) 
										{
											
											if ($showPanier[$i][3] == 1) 
											{
												$requeteDelete = $bdd->executeonly("DELETE FROM panier WHERE id = '$idProduit'");
												header('Location:panier.php');
											}
											else
											{
												$quantite = $showPanier[$i][3] - 1 ; 
												$req = $bdd->executeonly("UPDATE panier SET quantite = '$quantite' WHERE id= '$idProduit'");

												$prix = $quantite * $showPanier[$i][9];
												$req = $bdd->executeonly("UPDATE panier SET prix = '$prix' WHERE id= '$idProduit'");

												header('Location:panier.php');
											}	
										}

										if (isset($_POST["plus$idProduit"])) 
										{
											$quantite = $showPanier[$i][3] + 1 ;
											$req = $bdd->executeonly("UPDATE panier SET quantite = '$quantite' WHERE id= '$idProduit'");

											$prix = $quantite * $showPanier[$i][9];
											$req = $bdd->executeonly("UPDATE panier SET prix = '$prix' WHERE id= '$idProduit'");

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
										<td colspan="6"><input type="submit" name="commande" value="Commande"></td>
									</tr>

									<?php
									if (isset($_POST["commande"])) 
									{
										header('location:commande.php');
									}
								}
								else
								{
									echo "Votre Panier est vide";
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