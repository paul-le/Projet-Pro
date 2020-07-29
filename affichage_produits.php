<?php
    session_start();


    $vegan = $_POST['isVegan'];

    function getPlats($vegan = ""){

        if($vegan == ""){

        $requeteVegan = "SELECT * FROM plats";
        }
        else{
            $requeteVegan = "SELECT * FROM plats WHERE description LIKE '%$vegan%' ";
        }

        $connexion = mysqli_connect("localhost","root","","projetpro");
        $getPlatsQuery = mysqli_query($connexion,$requeteVegan);
        $resultatGetPlats = mysqli_fetch_all($getPlatsQuery);
        $jSON = json_encode($resultatGetPlats);
        
        echo $jSON;
    }

    getPlats($vegan);
?>