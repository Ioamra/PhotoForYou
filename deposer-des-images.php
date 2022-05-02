<?php
session_start();
if(empty($_SESSION['grade'])){
    header('location:index.php');
    exit();
}
if($_SESSION['grade'] != 'photographe'){
	if(($_SESSION['grade'] != 'admin')){
		header('location:index.php');
		exit();
	}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Déposer des images</title>
	<?php include "includes/head.php"; ?>
</head>
	<body>
		<?php 
		include "includes/bdd.php";
		include "includes/nav.php";
        include "includes/gestion-deposer-des-images.php";

		?>
        
		<div class="row justify-content-center mt-4" style="width:100%;">
            <h1 class="text-center mt-4">Déposer des images</h1>
            <div class="col-4 text-center">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nom_image" class="form-label">Nom</label>
                        <input type="text" class="form-control" name="nom_image" pattern="{3,20}" required>
                    </div>
                    <div class="mb-3">
                        <label for="categorie1" class="form-label">Catégorie</label><br/>
                        <select name="categorie">
                            <option value=''>Veuillez choisir une catégorie</option>
                            <?php
                                //* liste des categorie dans option
                                $req = $bdd->query("SELECT * FROM Categorie");
                                $data = $req->fetchAll();
                                foreach ($data as $li){
                                    echo '<option>'.$li['nom_categorie'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Image</label><br/>
                        <input class="align-center" type="file" name="img" id='img' onchange="loadFile(event)" required>
                    </div>
                    <div class="mb-3">
                        <label for="prix_image" class="form-label">Prix (entre 250 et 25 000 crédits)</label>
                        <input class="form-control" name="prix_image" pattern="[0-9]{1,11}" required>
                    </div>
                    
                    <button type="submit" name="submit" class="btn btn-primary">Publier</button>
                    <?=@$mes_error ?>
                </form>
            </div>
            <!-- //* Previsualisation de l'image qui vient d'arriver -->
            <div class="col-4"><img style="height:auto; width:40em" id="output" /></div>
        </div>

		<?php include "includes/footer.php"; ?>

        <script>
        //* script pour l'affichage automatique de l'image
            var loadFile = function(event){
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function(){
                    URL.revokeObjectURL(output.src);
                }
            }
        </script>
	</body>
</html>