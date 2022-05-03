<?php
    session_start();
    if(empty($_SESSION['grade'])){
        header('location:index.php');
        exit();
    }
    if($_SESSION['grade'] != 'admin'){
        header('location:index.php');
        exit();
    }else{

        include "includes/bdd.php";
    
        if (isset($_GET["nom_categorie"])) {
    
            $nom_categorie = $_GET["nom_categorie"];

            $req = $bdd->query("SELECT * FROM image WHERE nom_categorie = '$nom_categorie'");
            $nbImg = $req->rowCount();
            if ($nbImg == 0) {
                //* Supprime dans la bdd la categorie
                    $req = $bdd->prepare("DELETE FROM categorie WHERE nom_categorie = :nom_categorie");
                    $req->bindValue(':nom_categorie', $nom_categorie);
                    $req->execute();            
                //* supprime le dossier de la categorie
                    rmdir('upload/'.str_replace(" ", "-", $nom_categorie)); 
                    header("location:gestion-categorie.php");
            } else {
                echo "<script>alert('Vous ne pouvez pas supprimer cette catégorie, il y a encore des images qui en font partie.');window.location.href='gestion-categorie.php'</script>";
            }
        }
    }
?>
