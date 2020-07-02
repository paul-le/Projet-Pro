function selectViande(){
    var les_deux = getElementById("exempleRadios1");
    var avec_viande = getElementById("exempleRadios2");
    var sans_viande = getElementById("exempleRadios3");

}

$("#radioCheckLesDeux").click(function(){

    $.ajax({
        url : 'affichage_produits.php',
        type : 'POST',
        data : {isVegan : ""},
        success : function(data){
            var resultat = jQuery.parseJSON(data);
            $("#generationPlats").empty()
            $.each(resultat,function(){
                console.log(this[1]);
                $("#generationPlats").append('<div class="card-group col-3"><div class="card" id="platsCards" style="width: 18rem;"><img src="'+this[5]+'" class="card-img-top" alt="..."><div class="card-body"><h5 class="card-title">'+this[1]+'</h5><p class="card-text">'+this[2]+'</p><a href="#" class="btn btn-success">'+this[4]+'€</a></div></div></div>')
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
                $("#generationPlats").append('<div class="card-group col-3"><div class="card" id="platsCards" style="width: 18rem;"><img src="'+this[5]+'" class="card-img-top" alt="..."><div class="card-body"><h5 class="card-title">'+this[1]+'</h5><p class="card-text">'+this[2]+'</p><a href="#" class="btn btn-success">'+this[4]+'€</a></div></div></div>')
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
                $("#generationPlats").append('<div class="card-group col-3"><div class="card" id="platsCards" style="width: 18rem;"><img src="'+this[5]+'" class="card-img-top" alt="..."><div class="card-body"><h5 class="card-title">'+this[1]+'</h5><p class="card-text">'+this[2]+'</p><a href="#" class="btn btn-success">'+this[4]+'€</a></div></div></div>')
            })
        }
    });

});

// $('body').click(function(){
//     alert('Serge enfoiré');
// })