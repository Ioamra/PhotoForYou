<?php
session_start();
include "includes/bdd.php";
//* Verif de l'etat de connection
if (empty($_SESSION['grade'])) {
    echo("Vous devez vous connectez pour faire des achats.");
    return;
}
$req = $bdd->prepare("SELECT credits FROM user WHERE id = :id");
$req->bindValue(':id', $_SESSION['id']);
$req->execute();
$data = $req->fetch(\PDO::FETCH_OBJ);
$credits = $data->credits;
//* Verif qu'il y a suffisament de crédits pour acheter
if ($credits < $_GET['prixTotal']) {
    echo("Vous n\'avez pas assez de crédits.");
    return;
}
$tabIdImage = explode(',',$_GET['idImages']);
$date = date('d/m/Y');
$heure = date('H')+2;
$heure .= date(':i');
foreach ($tabIdImage as $id) {
    $req = $bdd->prepare('UPDATE image SET id_acheteur = :id_acheteur, date_achat = :date_achat, heure_achat = :heure WHERE id_image = :id_image');
    $req->bindValue(':id_acheteur', $_SESSION['id']);
    $req->bindValue(':date_achat', $date);
    $req->bindValue(':heure', $heure);
    $req->bindValue(':id_image', $id);
    $req->execute();
}

//* Modif credits acheteur
$credits = $credits - $_GET['prixTotal'];
$req = $bdd->prepare('UPDATE user SET credits = :credits WHERE id = :id');
$req->bindValue(':credits', $credits);
$req->bindValue(':id', $_SESSION['id']);
$req->execute();

//* pour chaque image => Modif credits vendeur
foreach ($tabIdImage as $id) {
    $req = $bdd->prepare("SELECT prix_image, id_vendeur FROM image WHERE id_image = :id_image");
    $req->bindValue(':id_image', $id);
    $req->execute();
    $data = $req->fetch(\PDO::FETCH_OBJ);
    $prix_image = $data->prix_image;
    $id_vendeur = $data->id_vendeur;

    //* Credits avant modif
    $req = $bdd->prepare("SELECT credits FROM user WHERE id = :id");
    $req->bindValue(':id', $id_vendeur);
    $req->execute();
    $data = $req->fetch(\PDO::FETCH_OBJ);
    $credits = $data->credits;

    //* Modif credits vendeur
    $credits = $credits + $prix_image;

    $req = $bdd->prepare('UPDATE user SET credits = :credits WHERE id = :id');
    $req->bindValue(':credits', $credits);
    $req->bindValue(':id', $id_vendeur);
    $req->execute();
}

?>