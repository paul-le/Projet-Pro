<?php

    session_start();
    $connexion = mysqli_connect("localhost","root","","projetpro");

    $requetePlats= "SELECT * FROM plats";
    $queryPlats= mysqli_query($connexion,$requetePlats);
    $resultatPlats= mysqli_fetch_all($queryPlats);
    $counterPlats= count($resultatPlats);
    
    // var_dump($resultatPlats);
    // var_dump($counterPlats);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- Balise indispensable pour le responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link href="css/fontawesome/css/all.css" rel="stylesheet"> <!--load all styles -->
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/stylesPaul.css">
    <title>Liste des produits</title>
</head>
<body>
<?php require("templates/header.phtml"); ?>
        <div class="">
            <img id="toastimg" src="img/toplisteplatbanner.jpg">
        </div>
    <main class="container">
        <div id="aboveListePlats">
            <h5>Les plats</h5>
            <p>Fraîchement cuisinés !</p>
        </div>
        <div class="dropdown"><br><br>
            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Filtre
            </button><br><br>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?php

                $i = 0;
                $requeteListeIngre = "SELECT * FROM ingredients";
                $queryListeIngre = mysqli_query($connexion, $requeteListeIngre);
                $resultatListeIngre = mysqli_fetch_all($queryListeIngre);
                $countIngre = count($resultatListeIngre);
                
                while($i != $countIngre){ ?>
                  
                
                    <div class="form-check" id="radioCheckLesDeux">
                        <input class="form-check-input ingredient-filter" type="radio" name="radioViande" id="exampleRadios<?php echo "".$resultatListeIngre[$i][1].""; ?>" value="<?php echo "".$resultatListeIngre[$i][1].""; ?>">
                        <label class="form-check-label" for="exampleRadios<?php echo "".$resultatListeIngre[$i][1].""; ?>">
                            <?php echo "".$resultatListeIngre[$i][1].""; ?>
                        </label>
                    </div>
                
            <?php $i++; } ?>
            </div>
        </div>
        <div class="d-flex flex-row col-12" id="generationPlats">
            <?php
                $i = 0;
                while($i < $counterPlats)
                {
                    // echo "".$resultatPlats[$i][1]." - ".$resultatPlats[$i][2]."<img src='".$resultatPlats[$i][5]."'><br>";
                    // $i++;
                ?>
                <!-- <div class="d-flex flex-row"> -->
                    <div class="card-group col-lg-3 col-xs-6 col-md-4">
                        <div class="card" id="platsCards" style="width: 18rem;">
                            <img src="<?php echo "photoProduit/".$resultatPlats[$i][5].""; ?>" class="card-img-top" alt="...">
                            <h5 class="card-title"><?php echo "".$resultatPlats[$i][1].""; ?></h5>
                            <div class="card-body">
                                    <!-- <p class="card-text"><?php/* echo "".$resultatPlats[$i][2].""; */?></p> -->
                                    <div id="card-bottom-desc">
                                        <div id="calories-part">
                                            <p id="cal-number-card">3000</p>
                                            <p id="cal-bottom-card">Calories</p>
                                        </div>
                                        <?php echo "".$resultatPlats[$i][4]." €"; ?>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal<?php echo "".$i.""; ?>">
                                            Infos
                                        </button>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal left fade" id="exampleModal<?php echo "".$i.""; ?>" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="nav flex-sm-column flex-row">
                                    <h1 class="card-title2">
                                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="<?php echo "photoProduit/".$resultatPlats[$i][5].""; ?>" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="<?php echo "photoProduit/".$resultatPlats[$i][6].""; ?>" class="d-block w-100" alt="...">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
                                    <h3 id="titrePlats1"><?php echo "".$resultatPlats[$i][1].""; ?></h3>
                                    <div id="above-modal-desc">
                                        <p id="valeur-nutri-p"> Valeur nutritionnelle</p>
                                        <?php echo "<p id='prix-dans-modal'>".$resultatPlats[$i][4]." € </p>"; ?>
                                        <button type="button" id="toasty" class="btn btn-success">Ajouter au panier</button>
                                    </div>
                                    <div id="modal-description-zone">
                                    <p id="modal-description"><?php echo "".$resultatPlats[$i][2].""; ?></p>
                                    </div>
                                    </div>
                                </div>

                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
            <?php
                $i++;
                }
            ?>
            </div>
    </main>
    <?php require("templates/footer.phtml"); ?>
    <script src="style/toast.js" type="text/javascript"></script>
    <script src="style/jQuery.js" type="text/javascript"></script>
</body>
</html>