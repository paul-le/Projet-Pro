<?php
    session_start();


    $vegan = $_POST['isVegan'];

    function getPlats($isVegan = ""){

        if($isVegan == ""){

        $requeteVegan = "SELECT * FROM plats";
        }
        elseif($isVegan == 'non'){
            $requeteVegan = "SELECT * FROM plats WHERE viande = 'non' ";
        }
        else{
            $requeteVegan = "SELECT * FROM plats WHERE viande = 'oui' ";
        }

        $connexion = mysqli_connect("localhost","root","","projetpro");
        $getPlatsQuery = mysqli_query($connexion,$requeteVegan);
        $resultatGetPlats = mysqli_fetch_all($getPlatsQuery);
        $jSON = json_encode($resultatGetPlats);
        
        echo $jSON;
    }

    getPlats($vegan);
?>