<?php session_start(); ?>
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
		include "includes/panier.php"; 
    
//! historique achat/vente

if(!empty($_GET['id'])){
  $id = $_GET['id'];

  //* nombre d'image mis en vente par le id_vendeur
  $req = $bdd->prepare("SELECT * FROM image WHERE id_vendeur = '$id'");
  $req->execute();
  $nb_image = $req->rowCount();

  //* Recuperation des info de l'utilisateur en fonction du $_GET
  $req = $bdd->query("SELECT * FROM user WHERE id = '$id'");
  $data = $req->fetchAll();
  foreach ($data as $li){
?>

<section class="h-100 gradient-custom-2">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="card">
          <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
            <div class="ms-4 mt-5 d-flex flex-column">
			        <!-- Image de l'utilisateur -->
              <div style="z-index:1;">
                <div class="img-fluid img-thumbnail mt-4 mb-2" style="background-size: cover; width: 150px; height: 150px; background-image:url(<?php echo $li['img_profil']; ?>)"></div>
              </div>
              <?php
            //* Editer le profil afficher uniquement si la SESSION correspond au GET
            if (isset($_SESSION['id'])) {
              if ($_SESSION['id'] == $id){
                echo '<a href="edit-profil.php?id='.$id.'" class="btn btn-outline-dark" style="z-index: 1;">Editer le profil</a>';
              }
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
                <!-- Tableau des information de l'utilisateur -->
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
                      <th scope="row">Pseudo :</th>
                      <td><?php echo $li['pseudo']; ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Mail :</th>
                      <td><?php echo $li['mail']; ?></td>
                    </tr>
                    <?php
                    if (isset($_SESSION['grade'])) {
                      if ($_SESSION['grade'] == 'photographe') {
                        echo '<tr>';
                        echo '  <th scope="row">N??siret :</th>';
                        echo '  <td>'.$li['SIRET'].'</td>';
                        echo '</tr>';
                      }
                    }
                    ?>
                    <tr>
                      <th scope="row">Credits :</th>
                      <td><?php echo $li['credits']; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <?php
          $req = $bdd->prepare("SELECT grade FROM user WHERE id = '$id'");
          $req->execute();
          $check = $req->fetch(\PDO::FETCH_OBJ);
          $check_grade = $check->grade;

          //* Si photographe => liste des images en vente
          if ($check_grade == 'photographe') {

            echo '<div class="card-body p-4 text-black">';
            echo '  <div class="d-flex justify-content-between align-items-center mb-4">';
            echo '    <p class="lead fw-normal mb-0">Photos en ventes</p>';
            echo '  </div>';
            echo '  <div class="row g-2">';
            //* Liste des images de l'utilisateur qui sont encore achetable
            $req_img = $bdd->query("SELECT * FROM Image WHERE id_vendeur = '$id' AND id_acheteur IS NULL");
            $req_img->execute();
            $data_img = $req_img->fetchAll();
            echo '<section class="py-5">';
            echo '<div class="container px-4 px-lg-5 mt-5">';
            echo '<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';
            foreach ($data_img as $li_img){
          
                      echo '<div class="col mb-5">';
              echo '	<a style="text-decoration:none; color:black;" href="index.php?categorie='.$li_img['nom_categorie'].'&img='.$li_img['id_image'].'">';
                      echo '		<div class="card h-100">';
              //* image rogn?? width: auto; height: 15em;
              echo '			<div style="background-size: cover; width: auto; height: 15em; background-image:url('.str_replace("'", "\'", $li_img['chemin_image']).')"></div>';
                      echo '			<div class="card-body p-4">';
                      echo '				<div class="text-center">';
                      echo '					<h5 class="fw-bolder">'.$li_img['nom_image'].'</h5>';
                      echo 					$li_img['prix_image'].' cr??dits <hr/>';
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
            echo'  </div>';
            echo'</div>';

          }

          //* Si client et idClient == $_GET['id'] => liste des photos achet??es 
          if ($check_grade == 'client' && $_SESSION['id'] == $_GET['id']) {

            //* Liste des images achet??es par l'utilisateur
            $req_img = $bdd->query("SELECT * FROM Image WHERE id_acheteur = '$id'");
            $req_img->execute();

            if ($req_img->rowCount() > 0) {

              echo '<div class="card-body p-4 text-black">';
              echo '  <div class="d-flex justify-content-between align-items-center mb-4">';
              if ($req_img->rowCount() == 1) {
                echo '    <p class="lead fw-normal mb-0">Photos achet??e</p>';
              } else {
                echo '    <p class="lead fw-normal mb-0">Photos achet??es</p>';
              }
              echo '  </div>';
              echo '  <div class="row g-2">';
              $data_img = $req_img->fetchAll();
              echo '<section class="py-5">';
              echo '<div class="container px-4 px-lg-5 mt-5">';
              echo '<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';
              foreach ($data_img as $li_img){
                        echo '<div class="col mb-5">';
                echo '	<a style="text-decoration:none; color:black;" target="_blank" href="'.$li_img['chemin_image'].'">';
                        echo '		<div class="card h-100">';
                //* image rogn?? width: auto; height: 15em;
                echo '			<div style="background-size: cover; width: auto; height: 15em; background-image:url('.str_replace("'", "\'", $li_img['chemin_image']).')"></div>';
                        echo '			<div class="card-body p-4">';
                        echo '				<div class="text-center">';
                        echo '					<h5 class="fw-bolder">'.$li_img['nom_image'].'</h5>';
                        echo 					$li_img['prix_image'].' cr??dits <hr/>';
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
              echo'  </div>';
              echo'</div>';

            }

          }


//////////* End Profil de base //////////
    ?>

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