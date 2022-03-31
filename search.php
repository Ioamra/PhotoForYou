<?php
include "includes/bdd.php";
if ($_GET['search']) {
    if (!empty($_GET['categorie'])) {
        getImages();
    } else {
        getCategorie();
    }
}

function getImages() {
    include "includes/bdd.php";
    $categorie = $_GET['categorie'];
    $search = $_GET['search'];
    $req = $bdd->prepare("SELECT * FROM Image WHERE nom_categorie = :categorie AND nom_image LIKE '%$search%' AND id_acheteur IS NULL");
    $req->bindValue(':categorie', $categorie);
    $req->execute();
    $data = $req->fetchAll();
    echo(json_encode($data));
    return json_encode($data);
}

function getCategorie() {
    include "includes/bdd.php";
    $search = $_GET['search'];
    $req = $bdd->prepare("SELECT * FROM Categorie WHERE nom_categorie LIKE '%$search%'");
    $req->execute();
    $data = $req->fetchAll();
    $dataImg = [];
    foreach ($data as $i => $li) {
        $req_img = $bdd->prepare("SELECT chemin_image FROM Image WHERE nom_categorie = :nom_categorie 
            AND id_image = (SELECT max(id_image) FROM Image WHERE nom_categorie = :nom_categorie AND id_acheteur IS NULL ) ");
        $req_img->bindValue(':nom_categorie', $li['nom_categorie']);
        $req_img->execute();
        $data_img = $req_img->fetchAll();
        $dataImg[] = $data_img;
    }
    $res[] = $data;
    $res[] = $dataImg;
    echo(json_encode($res));
    return json_encode($res);
}
?>