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

			Viande : OUI <input type="checkbox" name="v1" >
					 NON <input type="checkbox" name="v0">
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

			

			if (isset($_POST['v1'])) 
			{
				$viande = 1 ;
			}
			else
			{
				$viande = 0 ;
			}

		
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


		Modifier Plat<br />
		<form action="" method="post">
			
		</form>

		
		Liste Plat<br />
		
		Liste User<br />
		<?php

		$allUser = $bdd->execute("SELECT * FROM utilisateurs");
		
		?>


	</main>

</body>
</html>