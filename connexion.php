<!DOCTYPE HTML>
<html>
	<head>
		<title>Connexion</title>
        <?php include "includes/head.php"; ?>
	</head>	
	<body>
<?php
    include "includes/bdd.php";
    include "includes/nav.php";

    if(isset($_POST['mail']) && isset($_POST['password'])){
    
        $mail = $_POST['mail'];
        $mdp = sha1($_POST['password']);
        
        $req_co = "SELECT mail, mdp FROM user WHERE mail = '$mail' AND mdp = '$mdp'";
        $co = $bdd->prepare($req_co);
        $co->execute();
        $user_exist = $co->rowCount();
        
        if($user_exist == 1){
            //* Verifiaction de l'etat du comte : attValid / valid / banni
            $req_etat = "SELECT etat FROM user WHERE mail = '$mail'";
            $r_e = $bdd->prepare($req_etat);
            $r_e->execute();
            $result_r_e = $r_e->fetch(\PDO::FETCH_OBJ);
            $etat =  $result_r_e->etat;

            if($etat == 'attValid'){
                $mess = 'Votre comte est en cour de validation.';
            }
            if($etat == 'banni'){
                $mess = 'Votre comte à été banni.';
            }
            if($etat == 'valid'){
                $req_grade = "SELECT grade FROM user WHERE mail = '$mail'";
                $r_g = $bdd->prepare($req_grade);
                $r_g->execute();
                $result_r_g = $r_g->fetch(\PDO::FETCH_OBJ);
                $grade =  $result_r_g->grade;

                $req_pseudo = "SELECT pseudo FROM user WHERE mail = '$mail'";
                $r_p = $bdd->prepare($req_pseudo);
                $r_p->execute();
                $result_r_p = $r_p->fetch(\PDO::FETCH_OBJ);
                $pseudo =  $result_r_p->pseudo;
    
                session_start();
                $_SESSION['grade'] = $grade;
                $_SESSION['mail'] = $mail;
                $_SESSION['pseudo'] = $pseudo;
                header("location:index.php");
            }
        }
    }

?>
        <div class="row justify-content-center mt-4">
            <div class="col-4 text-center">
                <form method="post">
                    <h1>Connexion</h1>
                    <div class="mb-3">
                        <label for="mail" class="form-label">Adresse Email</label>
                        <input type="email" class="form-control" name="mail" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </form>
                <hr/>
                <?php if(isset($mess)){echo $mess.'<hr/>';} ?>
                <a href="inscription.php">Vous n'avez pas de compte, inscrivez-vous !</a>
            </div>
        </div>


        <?php include "includes/footer.php"; ?>
	</body>
</html>