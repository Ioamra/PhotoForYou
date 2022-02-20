$(function(){
    actuPanier();
});
function tooglePanier() {

    if ($('#panier').attr('style').match('display: none;')) {
        // Agrandir
        $('#panier').show();
        $('#panier').animate({width: '24%'});
    } else {
        // Réduire
        $('#panier').animate({width: '0'}, function(){$('#panier').hide();});
    }
}

function actuPanier() {
    if (getNombreProduit() == 0) {
        $('#nav-panier').addClass('d-none');
        $('#dropdown-panier').html("");
    } else {
        $('#nav-panier').removeClass('d-none');
        $('#nombre-produit').text(getNombreProduit());
        let panier = getPanier();
        let contenu = "";
        contenu += '<ul class="list-group list-group-flush">';
        for (let i = 0; i < panier.length; i++) {
            contenu += '<div class="row rounded-3 p-2">';
            contenu += '    <div class="col-8">';
            contenu += '        <a href="index.php?categorie='+panier[i]['categorie']+'&img='+panier[i]['id']+'">';
            contenu += '            <div class="rounded-3" style="background-size: cover; width: auto; height: 10em; background-image:url('+"'"+panier[i]['url']+"'"+')"></div>';
            contenu += '        </a>';
            contenu += '    </div>';
            contenu += '    <div class="col">';
            contenu += '        <div class="">'+panier[i]['nom']+'</div>';
            contenu += '        <div class="">'+panier[i]['prix']+'</div>';
            contenu += '        <div class="btn btn-sm btn-secondary" role="button" onclick="removePanier({id:'+panier[i]['id']+'});actuPanier();">supprimer<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trash3 ps-2" viewBox="0 0 16 16"><path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/></svg></div>';
            contenu += '    </div>';
            contenu += '</div>';
        }
        contenu += '      <li class="list-group-item d-flex justify-content-between border-0 py-2 px-4 m-3 rounded-3">';
        contenu += '          <div>';
        contenu += '              <strong>Prix Total</strong>';
        contenu += '          </div>';
        contenu += '          <span><strong>'+getPrixTotal()+'</strong></span>';
        contenu += '      </li>';
        contenu += '</ul>';
        contenu += '<div class="justify-content-center">';
        contenu += '    <button type="button" class="btn btn-secondary mb-3" id="valider-achat">';
        contenu += '        Validé l\'achat';
        contenu += '    </button>';
        contenu += '</div>';
        $('#dropdown-panier').html(contenu);
        $('#valider-achat').on('click', function(){
            confirm('valider l\'achat');

        });
    }
}
// Fonction pour le pannier
// Pour l'utilisation =>    addPanier({id:12, nom:"BeauPaysage", prix:200, url:"url", categorie:"nom_categorie"});
//                          removePanier({id:12});

function savePanier(panier) {
    localStorage.setItem("panier", JSON.stringify(panier));
}

function getPanier() {
    let panier = localStorage.getItem('panier');
    if (panier == null) {
        return [];
    } else {
        return JSON.parse(panier);
    }
}

function addPanier(produit) {
    let panier = getPanier();
    panier.push(produit);
    savePanier(panier);
}

function removePanier(produit) {
    let panier = getPanier();
    panier = panier.filter(function(p){ return p.id != produit.id; });
    console.log(panier.filter(function(p){ return p.id != produit.id; }));
    savePanier(panier);
}

function getPrixTotal() {
    let panier = getPanier();
    let total = 0;
    for (let produit of panier) {
        total += produit.prix;
    }
    return total;
}

function getNombreProduit() {
    let panier = getPanier();
    let total = 0;
    for (let produit of panier) {
        total += 1;
    }
    return total;
}