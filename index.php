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
	<body>
		<?php 
		include "includes/bdd.php";
		include "includes/nav.php"; 
		include "includes/panier.php"; 
		?>

        <?php
	if(!empty($_GET['categorie'])){
		if(!empty($_GET['img'])){
//* Debut Image
			$categorie = $_GET['categorie'];
			$id_image = $_GET['img'];
			$req = $bdd->prepare("SELECT * FROM Image WHERE id_image = $id_image");
			$req->execute();
			$data = $req->fetch(\PDO::FETCH_OBJ);
			$cheminIMG = $data->chemin_image;
			$nomIMG = $data->nom_image;
			$prixIMG = $data->prix_image;
			$idIMG = $data->id_image;
			$idVendeur = $data->id_vendeur;
			if ($data->id_acheteur != NULL) {
				header('location:index.php');
			}

			$req = $bdd->prepare("SELECT pseudo FROM user WHERE id = $idVendeur");
			$req->execute();
			$data = $req->fetch(\PDO::FETCH_OBJ);
			$pseudoPhotographe = $data->pseudo;

			$infos_image = @getImageSize($cheminIMG);
			$largeur = $infos_image[0];
			$hauteur = $infos_image[1];

			echo '<button class="btn btn-danger m-2" onclick="window.location.href='."'".'index.php?categorie='.$categorie."'".'">Revenir à la liste des '.$categorie.'</button>';
			echo '<section>';
			echo '	<div class="container px-4 px-lg-5 my-3">';
			echo '		<div class="row gx-4 gx-lg-5 align-items-center">';
			echo '			<div class="col-md-6"><a href="'.$cheminIMG.'" target="_blank"><img class="card-img-top mb-5 mb-md-0" src="'.$cheminIMG.'" alt="..." /></a></div>';
			echo '			<div class="col-md-6">';
			echo '				<h1 class="display-5 fw-bolder">'.$nomIMG.'</h1>';
			echo '				<div class="fs-5 mb-5">';
			echo '					<span>'.$largeur.' px X '.$hauteur.' px</span><br>';
			echo '					<span>'.$prixIMG.' Credits</span>';
			echo '				</div>';
			echo '				<a class="btn" href="profil.php?id='.$idVendeur.'">de '.$pseudoPhotographe.'</a><br>';
			if (isset($_SESSION['grade'])) {
				if ($_SESSION['grade'] == 'client') {
					echo '				<div class="d-flex">';
					echo '					<button class="btn btn-outline-dark flex-shrink-0" type="button" onclick="ajouterAuPanier();" id="btn-ajouter-au-panier"';
					echo '						data-id="'.$idIMG.'" data-nom="'.$nomIMG.'" data-prix="'.$prixIMG.'" data-url="'.$cheminIMG.'" data-categorie="'.$categorie.'">Ajoutez au panier</button>';
					echo '				</div>';
				}
			}
			echo '			</div>';
			echo '		</div>';
			echo '	</div>';
			echo '</section>';
			?>
<?php
//* Fin Image
		}else{
//* Debut Liste des images
			?>
			<section>
				<button class="btn btn-danger m-2" onclick="window.location.href='index.php'">Revenir à la liste des catégories</button>
				<div class="container px-4 px-lg-5">
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