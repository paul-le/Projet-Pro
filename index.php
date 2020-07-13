<?php

session_start();
var_dump($_SESSION['id']);
var_dump($_SESSION['login']);

require 'class/bdd.php';
require 'class/user.php';

$user = new user();
$bdd = new bdd();

$bdd->connect();
?>

<!DOCTYPE html>
<html>
<head>
	<title>INDEX</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<header>
		


		<?php
		$nbArticlePanier = $bdd->execute("SELECT * FROM panier WHERE id_utilisateur = '".$_SESSION["id"]."'");
		$nbArticle = count($nbArticlePanier);
		echo $nbArticle;
		?>
		
		<div class="menu">

			<!--THE EVENTS TO SHOW AND HIDE THE MENUS.-->
			<a class="moremenu" onmouseover="showmenu('divLiCat');" 
			onmouseout="setTimeToHide()" href="panier.php"><img src="https://img.icons8.com/metro/26/000000/shopping-basket.png" width="40" /></a>

			<ul id="ul_Rep">
				<li>
					<div id="divLiCat" onmouseover="ReSetTimer()" 
					onmouseout="setTimeToHide()" 
					style="display:none;">

					<?php
					$showPanier = $bdd->execute("SELECT * FROM panier INNER JOIN plats ON panier.id_produit = plats.id INNER JOIN utilisateurs ON panier.id_utilisateur = utilisateurs.id WHERE id_utilisateur = '".$_SESSION['id']."'") ;

					?>

					<section>
						<form method="post" action="">

							<table id="panierIndex">

								<tbody>
									<tr>
										<td class="nameColumnProduit">Nom</td>
										<td class="nameColumnProduit">Photo</td>
										<td class="nameColumnProduit">Quantite</td>
										<td class="nameColumnProduit">Prix</td>
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
													<td class="nameColumnProduit"><?php echo $showPanier[$i][3]; ?></td>

													<td class="nameColumnProduit"><?php echo $showPanier[$i][4]; ?></td>


												</tr>

												<?php

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

				</div>
			</li>
		</ul>
	</div>
	





</header>
<main>
	<form action="" method="post">

		<input type="submit" value="DECO" name="deco">

	</form>
	<?php

	if (isset($_POST['deco'])) 
	{
		$user->disconnect();
	}
	?>
</main>
<script type="text/javascript" src="js/panierJS.js"></script>

</body>
</html>