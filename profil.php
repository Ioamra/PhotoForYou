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

//! ajouter la possibilité de modif les info
//! historique achat/vente
//! $_GET['pseudo'] pour voir le compte d'autre utilisateur

if(!empty($_GET['pseudo'])){
  $pseudo = $_GET['pseudo'];

    $req = $bdd->prepare("SELECT * FROM image WHERE vendeur = '$pseudo'");
    $req->execute();
    $nb_image = $req->rowCount();

    $req = $bdd->query("SELECT * FROM user WHERE pseudo = '$pseudo'");
    $data = $req->fetchAll();
    foreach ($data as $li){
?>

<section class="h-100 gradient-custom-2">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="card">
          <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
            <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
			<!-- Image de l'utilisateur -->
              <img src="<?php echo $li['img_profil']; ?>" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 150px; z-index: 1">
              <?php
              if($_SESSION['pseudo'] == $pseudo){
                echo '<button type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="z-index: 1;">Editer le profil</button>';
              }
              ?>
            </div>
            <div class="ms-3" style="margin-top: 160px;">
			<!-- Pseudo de l'utilisateur -->
              <h5><?php echo $li['pseudo']; ?></h5>
            </div>
          </div>
          <div class="p-4 text-black" style="background-color: #f8f9fa;">
            <div class="d-flex justify-content-end text-center py-1">
              <div>
				  <!-- Compteur de photo -->
                <p class="mb-1 h5"><?php echo $nb_image; ?></p>
                <p class="small text-muted mb-0">Photos</p>
              </div>
            </div>
          </div>
          <div class="card-body p-4 text-black">
            <div class="mb-5">
              <p class="lead fw-normal mb-1">Mes information</p>
              <div class="p-4" style="background-color: #f8f9fa;">
              <table class="table">
                <tbody>
                  <tr>
                    <th scope="row">Nom :</th>
                    <td><?php echo $li['nom']; ?></td>
                  </tr>
                  <tr>
                    <th scope="row">Prenom :</th>
                    <td><?php echo $li['prenom']; ?></td>
                  </tr>
                  <tr>
                    <th scope="row">Mail :</th>
                    <td><?php echo $li['mail']; ?></td>
                  </tr>
                  <tr>
                    <th scope="row">N°siret :</th>
                    <td><?php echo $li['SIRET']; ?></td>
                  </tr>
                  <tr>
                    <th scope="row">Credits :</th>
                    <td><?php echo $li['credits']; ?></td>
                  </tr>
                </tbody>
              </table>
              </div>
            </div>
          <div class="card-body p-4 text-black">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <p class="lead fw-normal mb-0">Recent photos</p>
            </div>
            <div class="row g-2">
            <?php
              $req_img = $bdd->query("SELECT * FROM Image WHERE vendeur = '$pseudo'");
              $req_img->execute();
              $data_img = $req_img->fetchAll();
              echo '<section class="py-5">';
              echo '<div class="container px-4 px-lg-5 mt-5">';
              echo '<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';
              foreach ($data_img as $li_img){

                        echo '<div class="col mb-5">';
                echo '	<a style="text-decoration:none; color:black;" href="categorie.php?categorie='.$li_img['nom_categorie'].'&img='.$li_img['id_image'].'">';
                        echo '		<div class="card h-100">';
                //* image rogné width: auto; height: 15em;
                echo '			<div style="background-size: cover; width: auto; height: 15em; background-image:url('.$li_img['chemin_image'].')"></div>';
                        echo '			<div class="card-body p-4">';
                        echo '				<div class="text-center">';
                        echo '					<h5 class="fw-bolder">'.$li_img['nom_image'].'</h5>';
                        echo 					$li_img['prix_image'].' crédits <hr/>';
                        echo 					$li_img['nom_categorie'];
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
        </div>
    </div>
  </div>
</section>

<?php
    }
}
?>


		<?php include "includes/footer.php"; ?>
	</body>
</html>