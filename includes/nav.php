<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Photo For You</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto">
        <?php
      if(isset($_SESSION['grade'])){
          echo '<li class="nav-item"><a class="nav-link" href="profil.php?pseudo='.$_SESSION['pseudo'].'">Mon compte</a></li>';
      }
          ?>
        <li class="nav-item"><a class="nav-link" href="categorie.php">Catégorie</a></li>

<?php

        if(isset($_SESSION['grade'])){
          if($_SESSION['grade'] == 'admin'){
            $req = $bdd->query("SELECT acte, lien FROM navbar WHERE droit=1");
            $data = $req->fetchAll();
            echo '<li class="nav-item dropdown">';
              echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Client</a>';
              echo '<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                foreach ($data as $li){
                  echo '<li><a class="dropdown-item" href='.$li['lien'].'>'.$li['acte'].'</a></li>';
                }
              echo '</ul>';
            echo '</li>';
              
            $req = $bdd->query("SELECT acte, lien FROM navbar WHERE droit=2");
            $data = $req->fetchAll();
            echo '<li class="nav-item dropdown">';
              echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Photographe</a>';
              echo '<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                foreach ($data as $li){
                  echo '<li><a class="dropdown-item" href='.$li['lien'].'>'.$li['acte'].'</a></li>';
                }
                echo '</ul>';
              echo '</li>';

            $req = $bdd->query("SELECT acte, lien FROM navbar WHERE droit=3");
            $data = $req->fetchAll();
            foreach ($data as $li){
              echo '<li class="nav-item"><a class="nav-link" href='.$li['lien'].'>'.$li['acte'].'</a></li>';
            }
          }

          if($_SESSION['grade'] == 'photographe'){
            $req = $bdd->query("SELECT acte, lien FROM navbar WHERE droit=2");
            $data = $req->fetchAll();
            foreach ($data as $li){
              echo '<li class="nav-item"><a class="nav-link" href='.$li['lien'].'>'.$li['acte'].'</a></li>';
            }
          }

          if($_SESSION['grade'] == 'client'){
            $req = $bdd->query("SELECT acte, lien FROM navbar WHERE droit=1");
            $data = $req->fetchAll();
            foreach ($data as $li){
              echo '<li class="nav-item"><a class="nav-link" href='.$li['lien'].'>'.$li['acte'].'</a></li>';
            }
          }
        }

        if(empty($_SESSION['grade'])){
          echo '<li class="nav-item"><a class="nav-link" href="acheter-des-credits.php">Tarif</a></li>';
        }
?> 
        <li class="nav-item"><a class="nav-link" href="nous-contacter.php">Nous contacter</a></li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Recherche" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Recherche</button>
      </form>
      <ul class="navbar-nav">
<?php
        if(isset($_SESSION['grade'])){
          echo '<li class="nav-item"><a class="nav-link" href="includes/logout.php">Déconnection</a></li>';
        }else{
          echo '<li class="nav-item"><a class="nav-link" href="connexion.php">Connexion</a></li>';
          echo '<li class="nav-item"><a class="nav-link" href="inscription.php">Inscription</a></li>';
        }
?>
        
        
      </ul>
    </div>
  </div>
</nav>