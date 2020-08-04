<?php
	
	class produits extends bdd
	{
		private $id = NULL ;
		private $nom = NULL ;
		private $description = NULL ;
		private $prix = NULL ;
		private $id_categorie = NULL ;
		private $img1 = NULL ;
		private $img2 = NULL ;
		

		
		public function addCategorie($nom, $bdd)
		{
			if (strlen($nom) != 0) 
			{
				$categorie = $bdd->execute("SELECT nom FROM categorie WHERE nom = '$nom'");

				if (empty($categorie)) 
				{
					$newCategorie = $bdd->executeonly("INSERT INTO categorie (nom) VALUES ('$nom')");
					return "newCategorie";
				}
				else
				{
					return "categorieExistante";
				}
			}
			else
			{
				return "info";
			}
		}

		public function addIngredient($nom, $bdd)
		{
			if (strlen($nom) != 0) 
			{
				$ingredient = $bdd->execute("SELECT nom FROM ingredients WHERE nom = '$nom'");

				if (empty($ingredient)) 
				{
					$newIngredient = $bdd->executeonly("INSERT INTO ingredients (nom) VALUES ('$nom')");
					return "newIngredient";
				}
				else
				{
					return "ingredientExistant";
				}
			}
			else
			{
				return "info";
			}
		}



		public function addProduit($nom, $description, $prix, $id_categorie, $img1, $img2, $bdd)
		{
			if (strlen($nom) != 0 && strlen($description) != 0 && !empty($prix) && !empty($img1) && !empty($img2)) 
			{
				$produit = $bdd->execute("SELECT nom FROM plats WHERE nom = '$nom'");

				if (empty($produit)) 
				{
					$newProduit = $bdd->executeonly("INSERT INTO plats (nom, description, prix, id_categorie, img1, img2) VALUES ('$nom', '$description', '$prix', '$id_categorie', '$img1', '$img2' )");

					return "newProduit";
				}
				else
				{
					return "produitExist";
				}
			}
			else
			{
				return "info";
			}
		}

		public function updateProduits($updateNom, $updateDescription, $updatePrix, $updateCategorie, $updateImg1, $updateImg2, $id, $bdd)
		{
			
			if (!empty($updateNom)) 
			{
				$update = $bdd->executeonly("UPDATE plats SET nom = '$updateNom' WHERE id ='$id' ");
				header('location:admin.php');
			}
			
			if (!empty($updateDescription)) 
			{
				$update = $bdd->executeonly("UPDATE plats SET description = '$updateDescription' WHERE id ='$id' ");
				header('location:admin.php');

			}

			if (!empty($updatePrix)) 
			{
				
				$update = $bdd->executeonly("UPDATE plats SET prix = '$updatePrix' WHERE id ='$id'");
				header('location:admin.php');
			}

			if (!empty($updateCategorie)) 
			{
				$update = $bdd->executeonly("UPDATE plats SET id_categorie = '$updateCategorie' WHERE id ='$id'");
				header('location:admin.php');
				
			}

			if (!empty($updateImg1)) 
			{
				$img = $bdd->execute("SELECT img1 FROM plats WHERE id = '$id' ");
				var_dump($img);
				$filePath = 'photoProduit/'.$img[0][0];
				if (file_exists($filePath)) 
				{
					unlink($filePath);
					$update = $bdd->executeonly("UPDATE plats set img1 = '$updateImg1' WHERE id ='$id'  ");
					echo "UPDATE plats set img1 = '$updateImg1' WHERE id ='$id' ";
					header('location:admin.php');
				}
				else
				{
					echo "File does not exists"; 
				}

				
				
			}
			

			if (!empty($updateImg2))
			{
				$img = $bdd->execute("SELECT img2 FROM plats WHERE id = '$id' ");
				
				var_dump($img);
				$filePath = 'photoProduit/'.$img[0][0];
				if (file_exists($filePath)) 
				{
					unlink($filePath);
					$update = $bdd->executeonly("UPDATE plats set img2 = '$updateImg2' WHERE id ='$id' ");
					echo "UPDATE plats set img2 = '$updateImg2' WHERE id ='$id'   ";
					header('location:admin.php');
				}
				else
				{
					echo "File does not exists"; 
				}

				
				
			}
			

		}

		

		
		
	}

?>