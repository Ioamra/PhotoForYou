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
				echo '				<div class="fs-5 mb-2">';
				echo '					<span>'.$li['prix_image'].' Credits</span>';
				echo '				</div>';
				echo '				<div class="row">';
				echo '					<div class="col-5 col-sm-5 col-md-4 col-lg-3">';
				echo '						<p>Vendeur : </p>';
				echo '						<p>Dimention : </p>';
				echo '						<p>Catégorie : </p>';
				echo '					</div>';
				echo '					<div class="col">';
				//* Recuperation du pseudo du vendeur de l'image
				$req = $bdd->prepare("SELECT pseudo FROM user WHERE id = :id");
				$req->bindValue(':id', $li['id_vendeur']);
				$req->execute();
				$data = $req->fetchAll();
				foreach ($data as $li2){
					echo '					<p><a data-bs-toggle="tooltip" data-bs-placement="right" title="Voir le profil du photographe."
						style="text-decoration:none; color:black;" href="profil.php?id='.$li['id_vendeur'].'">'.$li2['pseudo'].'</a></p>';
				}
				$infos_image = @getImageSize($li['chemin_image']); // info sur la dimension de l'image
				$largeur = $infos_image[0];
				$hauteur = $infos_image[1];
				echo '						<p>'.$largeur.' x '.$hauteur.' px</p>';
				echo '						<p>'.$_GET['categorie'].'</p>';
				echo '					</div>';
				echo '				</div>';
				echo '				<div class="d-flex">';
				echo '					<button class="btn btn-outline-dark" type="button">Ajoutez au panier</button>';
				echo '				</div>';
				echo '			</div>';
				echo '		</div>';
				echo '	</div>';
				echo '</section>';
			}





		}else{
	//* Page avec la liste des images en fonction de la catégorie

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
				//* Recuperation du pseudo du vendeur de l'image
				$req = $bdd->prepare("SELECT pseudo FROM user WHERE id = :id");
				$req->bindValue(':id', $li['id_vendeur']);
				$req->execute();
				$data = $req->fetchAll();
				foreach ($data as $li2){
					echo '				<a data-bs-toggle="tooltip" data-bs-placement="right" title="Voir le profil du photographe." class="btn btn-outline-dark" 
						style="text-decoration:none; color:black;" href="profil.php?id='.$li['id_vendeur'].'">'.$li2['pseudo'].'</a><br/>';
				}
                echo 					$li['prix_image'].' crédits';
				$infos_image = @getImageSize($li['chemin_image']); // info sur la dimension de l'image
				$largeur = $infos_image[0];
				$hauteur = $infos_image[1];
				echo '					<p>'.$largeur.' x '.$hauteur.' px</p>';
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