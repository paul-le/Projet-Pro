<?php
	
	class produits extends bdd
	{
		private $id = NULL ;
		private $nom = NULL ;
		private $description = NULL ;
		private $prix = NULL ;
		private $id_categorie = NULL ;
		private $img = NULL ;
		private $viande = NULL ;

		
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



		public function addProduit($nom, $description, $prix, $id_categorie, $img, $viande, $bdd)
		{
			if (strlen($nom) != 0 && strlen($description) != 0 && !empty($prix) && !empty($img) && !empty($viande)) 
			{
				$produit = $bdd->execute("SELECT nom FROM plats WHERE nom = '$nom'");

				if (empty($produit)) 
				{
					$newProduit = $bdd->executeonly("INSERT INTO plats (nom, description, prix, id_categorie, img, viande) VALUES ('$nom', '$description', '$prix', '$id_categorie', '$img', '$viande' )");

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

		
		
	}

?>