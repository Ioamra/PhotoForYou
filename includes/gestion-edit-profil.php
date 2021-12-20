<?php
if (isset($_POST['edit-valid'])){

    $validation = True;

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pseudo = $_POST['pseudo'];
    $mail = $_POST['mail'];
    $siret = $_POST['siret'];
    $old_mdp = sha1($_POST['old-password']);
    $new_password1 = $_POST['new-password1'];
    $new_password2 = $_POST['new-password2'];

    if(strlen($nom) < 3 && strlen($nom) > 15){ $validation = False; }
    if(strlen($prenom) < 3 && strlen($prenom) > 15){ $validation = False; }
    if(strlen($pseudo) < 3 && strlen($pseudo) > 15){ $validation = False; }
    if(filter_var($mail, FILTER_VALIDATE_EMAIL) == False) { $validation = False; }


    $req = $bdd->prepare("SELECT nom, prenom, pseudo, img_profil, mail, SIRET FROM user WHERE id = '$id'");
    $req->execute();
    $result = $req->fetch(\PDO::FETCH_OBJ);
    $old_nom = $result->nom;
    $old_prenom = $result->prenom;
    $old_pseudo =  $result->pseudo;
    $old_img_profil = $result->img_profil;
    $old_mail =  $result->mail;
    $old_siret =  $result->SIRET;
    //* Vérification des doublons d'adresse mail hors lui meme
    if ($old_mail != $mail){
        $req = $bdd->prepare("SELECT mail FROM user WHERE mail = '$old_mail'");
        $req->execute();
        $result = $req->rowCount();
        if($result > 0){ $validation = False; $mes_error = 'Ce mail est déjà utilisé.'; }
    }

    //* Vérification des doublons de pseudo hors lui meme
    if ($old_pseudo != $pseudo){
        $req = $bdd->prepare("SELECT pseudo FROM user WHERE pseudo = '$old_pseudo'");
        $req->execute();
        $result = $req->rowCount();
        if($result > 0){ $validation = False; $mes_error = 'Ce pseudo est déjà utilisé.'; }
    }

    //* Vérification des doublons de num SIRET hors lui meme
    if ($old_siret != $siret){
        $req = $bdd->prepare("SELECT SIRET FROM user WHERE SIRET = '$siret'");
        $req->execute();
        $result = $req->rowCount();
        if($result > 0){ $validation = False; $mes_error = 'Ce numero de SIRET est déjà utilisé.'; }
    }

    //* Verification de l'ancien mot de passe
    $req = $bdd->prepare("SELECT mdp FROM user WHERE id = :id AND mdp = :mdp");
    $req->bindValue(':id', $id);
    $req->bindValue(':mdp', $old_mdp);
    $req->execute();
    $old_mdp_idem = $req->rowCount();
    if ($old_mdp_idem != 1) { $validation = False; $mes_error = 'Mot de passe incorrect.'; }

    //* Verification des nouveau mot de passe
    if($new_password1 != $new_password2){ $validation = False; $mes_error = 'Les nouveaux mots de passe ne correspondent pas.'; }

    //* Verification de l'image
    $file_name = $_FILES['img_profil']['name'];
    if($file_name != ''){
        $ext_img = ".".strtolower(substr(strrchr($file_name, "."), 1));
        if($ext_img != ".jpeg" && $ext_img != ".JPEG" && $ext_img != ".jpg" && $ext_img != ".JPG" && $ext_img != ".png" && $ext_img != ".PNG"){
            $validation = False;
            $mes_error = "Le format de l'image ne correspond pas";
        }
        $chemin_image = "upload/user/".$pseudo.$ext_img;
        $tmp_img = $_FILES['img_profil']['tmp_name'];
        
    }


    if($validation == True){
        
        //* ajout photo et suppr ancienne
        if($file_name != ''){
            if($old_img_profil != "upload/user/defaut.png"){
                unlink($old_img_profil);
            }
            move_uploaded_file($tmp_img, $chemin_image);
        }

        $mdp = sha1($new_password1);

        //* Requete sql evolutive en fonction des parametre a modifié
        $sql = "UPDATE user SET id = :id";
        if($old_nom != $nom){ $sql = $sql.", nom = :nom"; }
        if($old_prenom != $prenom){ $sql = $sql.", prenom = :prenom"; }
        if($old_pseudo != $pseudo){ $sql = $sql.", pseudo = :pseudo"; }
        if($file_name != ''){ $sql = $sql.", img_profil = :img_profil"; }
        if($old_mail != $mail){ $sql = $sql.", mail = :mail"; }
        if($new_password1 != ''){ $sql = $sql.", mdp = :mdp"; }
        if($old_siret != $siret){ $sql = $sql.", SIRET = :siret, etat = :etat"; }
        $sql = $sql." WHERE id = :id";

        $req = $bdd->prepare($sql);
        $req->bindValue(':id', $id);
        if($old_nom != $nom){ $req->bindValue(':nom', $nom); }
        if($old_prenom != $prenom){ $req->bindValue(':prenom', $prenom); }
        if($old_pseudo != $pseudo){ $req->bindValue(':pseudo', $pseudo); }
        if($file_name != ''){ $req->bindValue(':img_profil', $chemin_image); }
        if($old_mail != $mail){ $req->bindValue(':mail', $mail); }
        if($new_password1 != ''){ $req->bindValue(':mdp', $mdp); }
        if($old_siret != $siret){ 
            $req->bindValue(':siret', $siret);
            $req->bindValue(':etat', 'attValid');
        }

        $req->execute();

        if($old_siret != $siret || $new_password1 != ''){
            header('location:includes/logout.php');
        }else{
            header('location:profil.php?id='.$id);
        }
        
    }
}
?>