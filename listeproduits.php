<?php

    session_start();
    $connexion = mysqli_connect("localhost","root","","projetpro");

    $requetePlats= "SELECT * FROM plats";
    $queryPlats= mysqli_query($connexion,$requetePlats);
    $resultatPlats= mysqli_fetch_all($queryPlats);
    $counterPlats= count($resultatPlats);
    
    var_dump($resultatPlats);
    var_dump($counterPlats);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/bootstrap-4.5.0-dist/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Liste des produits</title>
</head>
<body>
    <main class="container">
        <div class="dropdown">
            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Viande
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        Les deux
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                    <label class="form-check-label" for="exampleRadios2">
                        Avec
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                    <label class="form-check-label" for="exampleRadios2">
                        Sans
                    </label>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row justify-content-around">
            <?php
                $i = 0;
                while($i < $counterPlats)
                {
                    // echo "".$resultatPlats[$i][1]." - ".$resultatPlats[$i][2]."<img src='".$resultatPlats[$i][5]."'><br>";
                    // $i++;
                ?>
                <!-- <div class="d-flex flex-row"> -->
                    <div class="card" style="width: 18rem;">
                        <img src="<?php echo "".$resultatPlats[$i][5].""; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo "".$resultatPlats[$i][1].""; ?></h5>
                                <p class="card-text"><?php echo "".$resultatPlats[$i][2].""; ?></p>
                                <a href="#" class="btn btn-success"><?php echo "".$resultatPlats[$i][4]." €"; ?></a>
                        </div>
                    </div>
                <!-- </div> -->
            <?php
                $i++;
                }
            ?>
            </div>
    </main>
</body>
</html>