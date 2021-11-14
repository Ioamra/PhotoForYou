<?php
$mes_error = '';
if (isset($_POST['submit'])){

    $validation = True;

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['mail'];
    $grade = $_POST['grade'];
    $siret = '';
    

    if(strlen($nom) < 3 && strlen($nom) > 15){ $validation = False; }

    if(strlen($prenom) < 3 && strlen($prenom) > 15){ $validation = False; }

    if(filter_var($mail, FILTER_VALIDATE_EMAIL) == False) { $validation = False; }

    if($grade != 'photographe' && $grade != 'client'){ $validation = False; }

    //* Vérification des doublons d'adresse mail
    $req = $bdd->prepare("SELECT * FROM user WHERE mail = '$mail'");
    $req->execute();
    $result = $req->rowCount();
    if($result > 0){ $validation = False; $mes_error = '<br/>Cette adresse mail est déjà utilisé.'; }

    //* Vérification des doublons de num SIRET
    if(!empty($_POST['siret'])){ 
        $siret = $_POST['siret']; 

        $req = $bdd->prepare("SELECT * FROM user WHERE SIRET = '$siret'");
        $req->execute();
        $result = $req->rowCount();
        if($result > 0){ $validation = False; $mes_error = '<br/>Ce numéro de SIRET est déjà utilisé.'; }
    }

    if($_POST['password1'] != $_POST['password2']){ $validation = False; $mes_error = '<br/>Les mots de passe ne corresponde pas.'; }

    if($validation == True){
        
        $mdp = sha1($_POST['password1']);   
        // * Si le comte est photographe il faut une validation de l'admin
        if($grade == 'photographe'){
            $etat = 'attValid';
        }
        if($grade == 'client'){
            $etat = 'valid';
        }

        $req = $bdd->prepare("INSERT INTO user (nom, prenom, mail, mdp, grade, SIRET, etat) 
                            VALUES (:nom, :prenom, :mail, :mdp, :grade, :siret, :etat)");
        $req->bindValue(':nom', $nom);
        $req->bindValue(':prenom', $prenom);
        $req->bindValue(':mail', $mail);
        $req->bindValue(':mdp', $mdp);
        $req->bindValue(':grade', $grade);
        $req->bindValue(':siret', $siret);
        $req->bindValue(':etat', $etat);
        $req->execute();

        if($etat == 'valid'){
            session_start();
            $_SESSION['grade'] = $grade;
            $_SESSION['mail'] = $mail;
            header("location:index.php"); 
        }
    }
}

?>