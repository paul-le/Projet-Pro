<?php

	session_start();

	require 'class/bdd.php';
	require 'class/user.php';

	$user = new user();
	$bdd = new bdd();
	
	$bdd->connect();

	$id = $_SESSION['id'];
	
	if (isset($_SESSION['id'])) 
	{

		$commande = $bdd->execute("SELECT * FROM panier INNER JOIN plats ON panier.id_produit = plats.id INNER JOIN utilisateurs ON panier.id_utilisateur = utilisateurs.id WHERE id_utilisateur = '".$_SESSION['id']."'") ;


		var_dump($commande);
		
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Commande</title>
</head>
<body>
	<main>
		
			<table>
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
						
						$nbProduit = count($commande);
						if ($nbProduit != 0) 
						{

							$i = 0 ;
							$prixTotal = 0;
							while ($i != $nbProduit) 
							{

								$idProduit = $commande[$i][0];

								?>
								<tr>
									<td class="nameColumnProduit"><?php echo $commande[$i][6]; ?></td>
									<td class="nameColumnProduit"><img src="photoProduit/<?php echo $commande[$i][10] ?>" width ="100" ></td>
									<td class="nameColumnProduit"><?php echo $commande[$i][3]; ?></td>
									<td class="nameColumnProduit"><?php echo $commande[$i][4]; ?></td>

									<td>
										<input type="submit" name="deleteProduit<?php echo $commande[$i][0]; ?>" value="Supprimer">
									</td>
								</tr>
							<?php
							$i++;	
							}
						}
					}
					?>
					<div id="paypal-button-container"></div>
					<script src="https://www.paypal.com/sdk/js?client-id=sb&currency=EUR" data-sdk-integration-source="button-factory"></script>
					<script>
						paypal.Buttons({
							style: {
								shape: 'pill',
								color: 'gold',
								layout: 'vertical',
								label: 'paypal',
								
							},
							createOrder: function(data, actions) {
								return actions.order.create({
									purchase_units: [{
										amount: {
											value: '10'
										}
									}]
								});
							},
							onApprove: function(data, actions) {
								return actions.order.capture().then(function(details) {
									alert('Transaction completed by ' + details.payer.name.given_name + '!');
								});
							}
						}).render('#paypal-button-container');
					</script>
				</tbody>
			</table>
			
		</main>

</body>
</html>