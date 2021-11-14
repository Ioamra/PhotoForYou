<?php
session_start();
if(empty($_SESSION['grade'])){
    header('location:index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Profil</title>
	<?php include "includes/head.php"; ?>
</head>
	<body>
		<?php 
		include "includes/bdd.php";
		include "includes/nav.php";
//! ajouter une image a l'inscription et dans la bdd
//! ajouter un pseudo a l'inscription et dans la bdd

//! charger la page en fonction de $_SESSION
//! ajouter la possibilité de modif les info
//! historique achat/vente en fonction de $_SESSION['grade']
		?>
<section class="h-100 gradient-custom-2">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="card">
          <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
            <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
			<!-- Ajouter l'image de l'utilisateur -->
              <img src="https://cdn.schoolstickers.com/products/en/819/104525-03.png" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 150px; z-index: 1">
              <button type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="z-index: 1;">
			  Editer le profil
              </button>
            </div>
            <div class="ms-3" style="margin-top: 160px;">
			<!-- Ajouter le pseudo de l'utilisateur -->
              <h5>Pseudonyme</h5>
            </div>
          </div>
          <div class="p-4 text-black" style="background-color: #f8f9fa;">
            <div class="d-flex justify-content-end text-center py-1">
              <div>
				  <!-- ajouter un compteur de photo // A VOIR si on compte tous ou juste les photos actuellement en vente -->
                <p class="mb-1 h5">Compteur de photo</p>
                <p class="small text-muted mb-0">Photos</p>
              </div>
            </div>
          </div>
          <div class="card-body p-4 text-black">
            <div class="mb-5">
              <p class="lead fw-normal mb-1">About</p>
              <div class="p-4" style="background-color: #f8f9fa;">
                <p class="font-italic mb-1">Web Developer</p>
                <p class="font-italic mb-1">Lives in New York</p>
                <p class="font-italic mb-0">Photographer</p>
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
              <p class="lead fw-normal mb-0">Recent photos</p>
              <p class="mb-0"><a href="#!" class="text-muted">Show all</a></p>
            </div>
            <div class="row g-2">
              <div class="col mb-2">
                <img src="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(112).jpg" class="w-100 rounded-3">
              </div>
              <div class="col mb-2">
                <img src="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(107).jpg" class="w-100 rounded-3">
              </div>
            </div>
            <div class="row g-2">
              <div class="col">
                <img src="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(108).jpg" class="w-100 rounded-3">
              </div>
              <div class="col">
                <img src="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(114).jpg" class="w-100 rounded-3">
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</section>

		<?php include "includes/footer.php"; ?>
	</body>
</html>