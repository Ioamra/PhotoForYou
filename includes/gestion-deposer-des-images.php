<?php
if(isset($_POST['submit'])){

    $validation = True;

    $nom_image = $_POST['nom_image'];
    $prix_image = $_POST['prix_image'];
    $categorie1 = $_POST['categorie1'];
    if(isset($_POST['categorie2'])){ $categorie2 = $_POST['categorie2']; }
    if(isset($_POST['categorie3'])){ $categorie3 = $_POST['categorie3']; }
    $vendeur_photo = $_SESSION['pseudo'];
    

    if(strlen($nom_image) < 3 && strlen($nom_image) > 20){ $validation = False; }

    // ! Verif que le nom n'existe pas dans la base de donnée
    // ! Prix minimum
    // ! Categorie existante dans la table categorie
    // ! isset $_FILES
    // ! .ext des image == jpg...

    // ! Remplacer les espace dans le titre de l'image pour le chemin


    if($validation == True){

        $file_name = $_FILES['img']['name'];
        $ext_img = ".".strtolower(substr(strrchr($file_name, "."), 1));
        $chemin_image = "upload/".$categorie1."/".$nom_image.$ext_img;
        $tmp_img = $_FILES['img']['tmp_name'];
        move_uploaded_file($tmp_img, $chemin_image);

        $categorie = $categorie1;
        
        if(!empty($categorie2)){ $categorie = $categorie.', '.$categorie2; }
        if(!empty($categorie3)){ $categorie = $categorie.', '.$categorie3; }

        $req = $bdd->prepare("INSERT INTO image (nom_image, prix_image, chemin_image, nom_categorie, vendeur) VALUES (:nom_image, :prix_image, :chemin_image, :nom_categorie, :vendeur)");
        $req->bindValue(':nom_image', $nom_image);
        $req->bindValue(':prix_image', $prix_image);
        $req->bindValue(':chemin_image', $chemin_image);
        $req->bindValue(':nom_categorie', $categorie);
        $req->bindValue(':vendeur', $vendeur_photo);
        $req->execute();
        
    }
}


?>