<?php
	session_start();

	require 'class/bdd.php';
	require 'class/user.php';
	require 'class/produits.php';

	$user = new user();
	$bdd = new bdd();
	$produit = new produits();
	
	$bdd->connect();



	

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
		<br />

		Ajouter Plat<br />
		<form action="" method="post">
			Nom : <input type="text" name="nameProduit" required><br />
			Description : <input type="textarea" name="descriptionProduit" required><br />
			Prix : <input type="number" name="prixProduit" required><br />
			IMG : <input type="file" name="imgProduit" required><br />
			Viande : OUI <input type="checkbox" name="v1" >
					 NON <input type="checkbox" name="v0">
					 <br />

			Categorie : <select>
					
							<option></option>
						</select>
			<input type="submit" name="addProduits" value="Ajouter">
				<?php
						$categorie = $bdd->execute("SELECT nom FROM categorie");
						var_dump($categorie);
						?>
		</form>

		<?php

		if (isset($_POST['newCategorie'])) 
		{
			$nom = $_POST['nameCategorie'];
			if ($produit->addCategorie($nom, $bdd) == "newCategorie") 
			{
				echo "Categorie Ajouter";
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


		if (isset($_POST['addProduits'])) 
		{
			$nom = $_POST['nomProduit'];
			$description = $_POST['descriptionProduit'];
			$prix = $_POST['prixProduit'];
			if (isset($_POST['v1'])) 
			{
				$viande = 1 ;
			}
			elseif (isset($_POST['v0'])) 
			{
				$viande = 0 ;
			}

			if (isset($_FILES['imgProduit']) AND !empty($_FILES['imgProduit'])) 
                {
                    $tailleMax = 2097152 ;
                    $extensionsValides = $arrayName = array('jpg', 'jpeg', 'gif', 'png');
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
                                $msg = "Erreur durant l'importation de votre photo de profil" ;
                            }
                        }
                        else
                        {
                            $msg = "Votre photo de profil doit être au format jpg, jpeg, gif ou png. ";
                        }

                    }
                    else
                    {
                        $msg = "Votre photo de profil ne doit pas dépasser 2Mo" ;
                    }
                }

                /*if ($produit->addProduits($nom, $description, $prix, )) 
                {
                	# code...
                }*/


			
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