<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Catégorie</title>
	<?php include "includes/head.php"; ?>
</head>
	<body>
		<?php 
		include "includes/bdd.php";
		include "includes/nav.php"; 
		?>
		
        <?php
	if(!empty($_GET['categorie'])){
		if(!empty($_GET['img'])){
	//* Page Image
	//! besoin d'un lien vers compte du photographe
			$categorie = $_GET['categorie'];
			$id_image = $_GET['img'];
			echo '<a href="categorie.php?categorie='.$categorie.'" class="m-3" style="text-decoration:none; color:red;">Revennir a la categorie '.$categorie.'.</a>';
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
				echo '					<button class="btn btn-outline-dark flex-shrink-0" type="button">Ajoutez au panier</button>';
				echo '				</div>';
				echo '			</div>';
				echo '		</div>';
				echo '	</div>';
				echo '</section>';
			}





		}else{
	//* Page avec la liste des images en fonction de la catégorie
	//! besoin d'un lien pour revenir en arriere
	//! afficher certaine caracteristique : dimention, lien vers le photographe

			$categorie = $_GET['categorie'];

			$req = $bdd->prepare("SELECT * FROM Image WHERE nom_categorie = :categorie AND id_acheteur IS NULL");
			$req->bindValue(':categorie', $categorie);
			$req->execute();
			$data = $req->fetchAll();
			echo '<a href="categorie.php" class="m-3" style="text-decoration:none; color:red;">Revennir a la liste des categories.</a>';
			echo '<section class="py-5">';
            echo '<div class="container px-4 px-lg-5 mt-5">';
            echo '<h2 class="fw-bolder mb-4 text-center">'.$categorie.'</h2>';
			echo '<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';
        	foreach ($data as $li){
		
                
                echo '<div class="col mb-5">';
				echo '	<a style="text-decoration:none; color:black;" href="categorie.php?categorie='.$li['nom_categorie'].'&img='.$li['id_image'].'">';
                echo '		<div class="card h-100">';
				//* image rogné width: auto; height: 15em;
				echo '			<div style="background-size: cover; width: auto; height: 15em; background-image:url('.$li['chemin_image'].')"></div>';
                echo '			<div class="card-body p-4">';
                echo '				<div class="text-center">';
                echo '					<h5 class="fw-bolder">'.$li['nom_image'].'</h5>';
                echo 					$li['prix_image'].' crédits';
                echo '				</div>';
                echo '			</div>';
                echo '		</div>';
				echo '	</a>';
				echo '</div>';
			}
			echo '</div>';
			echo '</div>';
			echo '</section>';
		}
	}else{
//* Page avec la liste des catégorie

?>
		<br/>
		<div class="container">
			<div class="row">
<?php
			$req = $bdd->query("SELECT * FROM Categorie");
            $data = $req->fetchAll();
			echo '<section class="py-5">';
            echo '<div class="container px-4 px-lg-5 mt-5">';
			echo '<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';            
            foreach ($data as $li){


				//* Image la plus rescente de la catégorie
				$req_img = $bdd->prepare("SELECT chemin_image FROM Image WHERE nom_categorie = :nom_categorie 
							AND id_image = (SELECT max(id_image) FROM Image WHERE nom_categorie = :nom_categorie AND id_acheteur IS NULL ) ");
				$req_img->bindValue(':nom_categorie', $li['nom_categorie']);
				$req_img->execute();
				$data_img = $req_img->fetchAll();
				echo '<div class="col mb-5">';
				echo '	<a style="text-decoration:none; color:black;" href="categorie.php?categorie='.$li['nom_categorie'].'">';
				echo '		<div class="card h-100">';
				foreach($data_img as $li2){
				//* image rogné width: auto; height: 15em;
					echo '		<div style="background-size: cover; width: auto; height: 15em; background-image:url('.$li2['chemin_image'].')"></div>';
				}
				echo '			<div class="card-body p-4">';
				echo '				<div class="text-center">';
				echo '					<h5 class="fw-bolder">'.$li['nom_categorie'].'</h5>';
				echo '				</div>';
				echo '			</div>';
				echo '		</div>';
				echo '	</a>';
				echo '</div>';
			}
			echo '</div>';
			echo '</div>';
			echo '</section>';
?>
		</div>
		</div>
<?php
	}
?>

		<?php include "includes/footer.php"; ?>
	</body>
</html>