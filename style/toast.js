// function selectViande(){
//     var les_deux = getElementById("exampleRadios1");
//     var avec_viande = getElementById("exampleRadios2");
//     var sans_viande = getElementById("exampleRadios3");

// }

$(".ingredient-filter").click(function(){

    var ingre = $(this).val();
    console.log(ingre);
    $.ajax({
        url : 'affichage_produits.php',
        type : 'POST',
        data : {isVegan : ingre},
        success : function(data){
            var resultat = jQuery.parseJSON(data);
            $("#generationPlats").empty()
            $.each(resultat,function(){
                console.log(this[1]);
                $("#generationPlats").append('<div class="card-group col-3"><div class="card" id="platsCards" style="width: 18rem;"><img src="photoProduit/'+this[5]+'" class="card-img-top" alt="..."><h5 class="card-title">'+this[1]+'</h5><div class="card-body"><div id="card-bottom-desc"><div id="calories-part"><p id="cal-number-card">3000</p><p id="cal-bottom-card">Calories</p></div><span id="prix-flex">'+this[4]+' €</span><button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal'+this[0]+'">Infos</button></div></div></div></div>')

                $("body").append(`<div class="modal left fade" id="exampleModal${this[0]}" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="nav flex-sm-column flex-row">
                            <h1 class="card-title2">
                            <img src="photoProduit/${this[5]}" class="card-img-top" alt="...">
                            <h3 id="titrePlats1">${this[1]}</h3>
                            <div id="above-modal-desc">
                                <p id="valeur-nutri-p">Valeur nutritionnelle</p>
                                <p id='prix-dans-modal'>${this[4]} € </p>
                                <button type="button" id="toasty" class="btn btn-success">Ajouter au panier</button>
                            </div>
                            <div id="modal-description-zone">
                            <p id="modal-description">${this[2]}</p>
                            </div>
                            </div>
                        </div>

                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>`)
            })
        }
    });

});

$("#radioCheckAvec").click(function(){
    $.ajax({
        url : 'affichage_produits.php',
        type : 'POST',
        data : {isVegan : "oui"},
        success : function(data){
            var resultat = jQuery.parseJSON(data);
            $("#generationPlats").empty()
            $.each(resultat,function(){
                console.log(this[1]);
                $("#generationPlats").append('<div class="card-group col-3"><div class="card" id="platsCards" style="width: 18rem;"><img src="photoProduit/'+this[5]+'" class="card-img-top" alt="..."><h5 class="card-title">'+this[1]+'</h5><div class="card-body"><div id="card-bottom-desc"><div id="calories-part"><p id="cal-number-card">3000</p><p id="cal-bottom-card">Calories</p></div><span id="prix-flex">'+this[4]+' €</span><button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal'+this[0]+'">Infos</button></div></div></div></div>')

                $("body").append(`<div class="modal left fade" id="exampleModal${this[0]}" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="nav flex-sm-column flex-row">
                            <h1 class="card-title2">
                            <img src="photoProduit/${this[5]}" class="card-img-top" alt="...">
                            <h3 id="titrePlats1">${this[1]}</h3>
                            <div id="above-modal-desc">
                                <p id="valeur-nutri-p">Valeur nutritionnelle</p>
                                <p id='prix-dans-modal'>${this[4]} € </p>
                                <button type="button" id="toasty" class="btn btn-success">Ajouter au panier</button>
                            </div>
                            <div id="modal-description-zone">
                            <p id="modal-description">${this[2]}</p>
                            </div>
                            </div>
                        </div>

                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>`)
            })
        }
    });

});

$("#radioCheckSans").click(function(){

    $.ajax({
        url : 'affichage_produits.php',
        type : 'POST',
        data : {isVegan : "non"},
        success : function(data){
            var resultat = jQuery.parseJSON(data);
            $("#generationPlats").empty()
            console.log(resultat);
            $.each(resultat,function(){
                console.log(this[1]);
                $("#generationPlats").append('<div class="card-group col-3"><div class="card" id="platsCards" style="width: 18rem;"><img src="photoProduit/'+this[5]+'" class="card-img-top" alt="..."><h5 class="card-title">'+this[1]+'</h5><div class="card-body"><div id="card-bottom-desc"><div id="calories-part"><p id="cal-number-card">3000</p><p id="cal-bottom-card">Calories</p></div><span id="prix-flex">'+this[4]+' €</span><button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal'+this[0]+'">Infos</button></div></div></div></div>')

                $("body").append(`<div class="modal left fade" id="exampleModal${this[0]}" tabindex="" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="nav flex-sm-column flex-row">
                            <h1 class="card-title2">
                            <img src="photoProduit/${this[5]}" class="card-img-top" alt="...">
                            <h3 id="titrePlats1">${this[1]}</h3>
                            <div id="above-modal-desc">
                                <p id="valeur-nutri-p">Valeur nutritionnelle</p>
                                <p id='prix-dans-modal'>${this[4]} € </p>
                                <button type="button" id="toasty" class="btn btn-success">Ajouter au panier</button>
                            </div>
                            <div id="modal-description-zone">
                            <p id="modal-description">${this[2]}</p>
                            </div>
                            </div>
                        </div>

                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>`)
            })
        }
    });

});