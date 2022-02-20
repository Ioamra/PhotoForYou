<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Photo For You</title>
	<?php include "includes/head.php"; ?>
	<script src="assets/js/fetch-image.js"></script>
</head>
	<body>			<!--		BTN pour revenir a la page precedente
		 <button class="btn btn-danger" onclick="history.go(-1)">Annuler les changement</button> -->
		<?php 
		include "includes/bdd.php";
		include "includes/nav.php"; 
		include "includes/panier.php"; 
		?>

        <?php
	if(!empty($_GET['categorie'])){
		if(!empty($_GET['img'])){
//* Debut Image
	//! besoin d'un lien pour revenir en arriere + vers compte du photographe
			$categorie = $_GET['categorie'];
			$id_image = $_GET['img'];
			$req = $bdd->prepare("SELECT * FROM Image WHERE id_image = :id_image");
			$req->bindValue(':id_image', $id_image);
			$req->execute();
			$data = $req->fetchAll();
			foreach ($data as $li){
				echo '<section class="py-5" >';
				echo '	<div class="container px-4 px-lg-5 my-5">';
				echo '		<div class="row gx-4 gx-lg-5 align-items-center">';
				echo '			<div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="'.$li['chemin_image'].'" alt="..." /></div>';
				echo '			<div class="col-md-6">';
				echo '				<h1 class="display-5 fw-bolder">'.$li['nom_image'].'</h1>';
				echo '				<div class="fs-5 mb-5">';
				echo '					<span>'.$li['prix_image'].' Credits</span>';
				echo '				</div>';
				//! ajouter dimention // lien vers le compte du photographe ...
				echo '				<p class="lead">écrire ici les caracteristique // taille // lien vers le compte du photographe ...</p>';
				echo '				<div class="d-flex">';
				echo '					<button class="btn btn-outline-dark flex-shrink-0" type="button"';
				echo '						onclick="addPanier({id:'.$li['id_image'].', nom:'."'".$li['nom_image']."'".', prix:'.$li['prix_image'].', url:'."'".$li['chemin_image']."'".', nom_categorie:'."'".$li['nom_categorie']."'".'});actuPanier();">Ajoutez au panier</button>';
				echo '				</div>';
				echo '			</div>';
				echo '		</div>';
				echo '	</div>';
				echo '</section>';
			}




//* Fin Image
		}else{
//* Debut Liste des images
			?>
			<section>
			<div class="container px-4 px-lg-5 mt-5">
			<h2 id="categorie-titre" class="fw-bolder mb-4 text-center"></h2>
			<div class="row">
				<div class="col-3"></div>
				<div class="col-6 form-outline mb-4">
					<input type="text" id="search" class="form-control text-center" placeholder="Rechercher une image" />
					</div>
				</div>
			<div id="liste-image" class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
			</div>
			</div>
			</section>
			<?php
		}
//* Fin Liste des images
	}else{
//* Debut Liste des catégorie
		?>
		<div class="container">
			<div class="row">
			<section >
			<div class="container px-4 px-lg-5 mt-5">
			<h2 class="fw-bolder mb-4 text-center">Catégorie</h2>
			<div class="row">
				<div class="col-3"></div>
				<div class="col-6 form-outline mb-4">
					<input type="text" id="search" class="form-control text-center" placeholder="Rechercher une catégorie" />
				</div>
			</div>
			<div id="liste-image" class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">    
			
			</div>
			</div>
			</section>
		</div>
		</div>
		<?php
	}
//* Fin Liste des catégorie
?>

		<?php include "includes/footer.php"; ?>
	</body>
</html>