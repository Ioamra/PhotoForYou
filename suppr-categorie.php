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
    
        //* Supprime dans la bdd la categorie
            $req = $bdd->prepare("DELETE FROM categorie WHERE nom_categorie = :nom_categorie");
            $req->bindValue(':nom_categorie', $nom_categorie);
            $req->execute();            
            header("location:gestion-categorie.php");
        //* supprime le dossier de la categorie
            rmdir('upload/'.$nom_categorie); 
        }
    }
?>