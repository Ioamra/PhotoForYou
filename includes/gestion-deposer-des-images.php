<?php
if(isset($_POST['submit'])){
    
    // ! Prix minimum / max

    $validation = True;

    $nom_image = $_POST['nom_image'];
    $prix_image = $_POST['prix_image'];
    $categorie1 = $_POST['categorie1'];
    
    //* verification que la categorie existe
    $req = $bdd->prepare("SELECT * FROM categorie WHERE nom_categorie = '$categorie1'");
    $req->execute();
    $result = $req->rowCount();
    if($result == 0){ $validation = False; }

    if($_POST['categorie2'] != ""){ 
        $categorie2 = $_POST['categorie2'];
        $req = $bdd->prepare("SELECT * FROM categorie WHERE nom_categorie = '$categorie2'");
        $req->execute();
        $result = $req->rowCount();
        if($result == 0){ $validation = False; }
    }
    if($_POST['categorie3'] != ""){ 
        $categorie3 = $_POST['categorie3'];
        $req = $bdd->prepare("SELECT * FROM categorie WHERE nom_categorie = '$categorie3'");
        $req->execute();
        $result = $req->rowCount();
        if($result == 0){ $validation = False; }
    }
    $vendeur_photo = $_SESSION['id'];
    
    if(strlen($nom_image) < 3 && strlen($nom_image) > 20){ $validation = False; }

    $file_name = $_FILES['img']['name'];
    $ext_img = ".".strtolower(substr(strrchr($file_name, "."), 1));
    if($ext_img != ".jpeg" && $ext_img != ".JPEG" && $ext_img != ".jpg" && $ext_img != ".JPG" && $ext_img != ".png" && $ext_img != ".PNG"){
        $validation = False;
        $mes_error = "Le format de l'image ne correspond pas";
    }

    if($validation == True){

    //* Renommage de l'image et ajout du chemin
        $chemin_image = "upload/".str_replace(" ", "-", $categorie1)."/".str_replace(" ", "-", $nom_image).$ext_img;
        $tmp_img = $_FILES['img']['tmp_name'];
        move_uploaded_file($tmp_img, $chemin_image);

        $categorie = $categorie1;
        
    //* Si d'autre categorie ont ete choisie -> virgule + la prochaine categorie
        if(!empty($categorie2)){ $categorie = $categorie.', '.$categorie2; }
        if(!empty($categorie3)){ $categorie = $categorie.', '.$categorie3; }

    //* Ajout dans la bdd
        $req = $bdd->prepare("INSERT INTO image (nom_image, prix_image, chemin_image, nom_categorie, id_vendeur) VALUES (:nom_image, :prix_image, :chemin_image, :nom_categorie, :id_vendeur)");
        $req->bindValue(':nom_image', $nom_image);
        $req->bindValue(':prix_image', $prix_image);
        $req->bindValue(':chemin_image', $chemin_image);
        $req->bindValue(':nom_categorie', $categorie);
        $req->bindValue(':id_vendeur', $vendeur_photo);
        $req->execute();
        
    }
}


?>