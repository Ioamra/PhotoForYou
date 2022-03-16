$(function(){
    let categorie = getURLParameter('categorie');
    if (categorie) {
        fetchSearchImage(categorie, '%');
        $('#search').on('keyup', function(){
            if (!$('#search').val()) {
                fetchSearchImage(categorie, '%'); 
            } else {
                fetchSearchImage(categorie, $('#search').val()); 
            }
        })
    } else {
        fetchSearchCategorie('%');
        $('#search').on('keyup', function(){
            if (!$('#search').val()) {
                fetchSearchCategorie('%'); 
            } else {
                fetchSearchCategorie($('#search').val());
            }
        })
    }
});

async function fetchSearchImage(categorie, search) {
    fetch('search.php?categorie='+categorie+'&search='+search)
        .then(res => res.text())
        .then((data) => {
            $('#categorie-titre').text(JSON.parse(data)[0].nom_categorie);
            let contenu ="";
            for (let i = 0; i < data.length; i++) {
                var li = JSON.parse(data)[i];
                
                contenu += '<div class="col mb-5">';
                contenu += '<a style="text-decoration:none; color:black;" href="index.php?categorie='+li.nom_categorie+'&img='+li.id_image+'">';
                contenu += '<div class="card h-100">';
                //* image rogné width: auto; height: 15em;
                contenu += '<div style="background-size: cover; width: auto; height: 15em; background-image:url('+li.chemin_image+')"></div>';
                contenu += '<div class="card-body p-4">';
                contenu += '<div class="text-center">';
                contenu += '<h5 class="fw-bolder">'+li.nom_image+'</h5>';
                contenu += 	li.prix_image+' crédits';
                contenu += '</div>';
                contenu += '</div>';
                contenu += '</div>';
                contenu += '</a>';
                contenu += '</div>';
                $('#liste-image').html(contenu);
            }
        }
    );
}

async function fetchSearchCategorie(search) {
    fetch('search.php?search='+search)
        .then(res => res.text())
        .then((data) => {
            let contenu ="";
            for (let i = 0; i < JSON.parse(data)[0].length; i++) {
                var li = JSON.parse(data);
                let nomCategorie = li[0][i].nom_categorie;
                let cheminImage = li[1][i][0].chemin_image;
                contenu += '<div class="col mb-5">';
				contenu += '	<a style="text-decoration:none; color:black;" href="index.php?categorie='+nomCategorie+'">';
				contenu += '		<div class="card h-100">';
				contenu += '		<div style="background-size: cover; width: auto; height: 15em; background-image:url('+cheminImage+')"></div>';
				
				contenu += '			<div class="card-body p-4">';
				contenu += '				<div class="text-center">';
				contenu += '					<h5 class="fw-bolder">'+nomCategorie+'</h5>';
				contenu += '				</div>';
				contenu += '			</div>';
				contenu += '		</div>';
				contenu += '	</a>';
				contenu += '</div>';
                $('#liste-image').html(contenu);
            }
        }
    )
}



function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
  }