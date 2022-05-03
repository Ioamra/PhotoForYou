<?php
session_start();
if(empty($_SESSION['grade'])){
    header('location:index.php');
    exit();
}
if($_SESSION['grade'] != 'admin'){
	header('location:index.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Gestion Catégorie</title>
	<?php include "includes/head.php"; ?>
</head>
	<body>
		<?php 
		include "includes/bdd.php";
		include "includes/nav.php";
		?>
    <?php
        if(isset($_POST['submit'])){
    
            $validation = True;
    
            $nom_categorie = $_POST['nom_categorie'];
    
            if(strlen($nom_categorie) < 3 && strlen($nom_categorie) > 20){ $validation = False; }
            //* Vérification des doublons de categorie
            $req = $bdd->prepare("SELECT * FROM categorie WHERE nom_categorie = '$nom_categorie'");
            $req->execute();
            $result = $req->rowCount();
            if($result > 0){ $validation = False; }
    
            if($validation == True){
                $req = $bdd->prepare("INSERT INTO categorie (nom_categorie) VALUES (:nom_categorie)");
                $req->bindValue(':nom_categorie', $nom_categorie);
                $req->execute();
                //* creer le dossier de la categorie dans upload
                mkdir('upload/'.str_replace(" ", "-", $nom_categorie)); 
            }
        }
    ?>
        <h1 class="text-center mt-4">Gestion Catégorie</h1>
		<div class="row justify-content-center mt-4 w-100">
            <div class="col-4 text-center">
        <!-- formulaire d'ajout de catégorie -->
                <form method="post">
                    <div class="mb-3">
                        <label for="nom_categorie" class="form-label">Nom de la catégorie</label>
                        <input type="text" class="form-control" name="nom_categorie" pattern="{3,20}" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Ajoutez</button>
                </form>
            </div>
            <div class="col-2"></div>
            <div class="col-4">
                <table class="text-center table table-bordered table-striped">
                    <tr>
                        <td class="p-2">Nom des catégories</td>
                        <td class="p-2">Supprimer</td>
                    </tr>
                <?php
                //* Affichage des categories avec lien pour supprimer
                    $req = $bdd->query("SELECT * FROM Categorie");
                    $data = $req->fetchAll();
                    foreach ($data as $li){
                        echo '<tr>';
                        echo '<td>'.$li['nom_categorie'].'</td>';
                        echo '<td><a href="suppr-categorie.php?nom_categorie='.$li['nom_categorie'].'">supprimer<a></td>';
                        echo '</tr/>';
                    }
                ?>
                </table>
            </div>
        </div>

		<?php include "includes/footer.php"; ?>
	</body>
</html>