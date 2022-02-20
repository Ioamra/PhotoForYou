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
          echo '<li class="nav-item"><a class="nav-link" href="profil.php?id='.$_SESSION['id'].'">Mon compte</a></li>';
      }
          ?>
<?php
        if(isset($_SESSION['grade'])){
//* Si l'utilisateur est admin
          if($_SESSION['grade'] == 'admin'){
    //* Dropdown client
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
    //* Dropdown photographe
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
    //* liste des page admin
            $req = $bdd->query("SELECT acte, lien FROM navbar WHERE droit=3");
            $data = $req->fetchAll();
            foreach ($data as $li){
              echo '<li class="nav-item"><a class="nav-link" href='.$li['lien'].'>'.$li['acte'].'</a></li>';
            }
          }
//* Si l'utilisateur est photographe
          if($_SESSION['grade'] == 'photographe'){
            $req = $bdd->query("SELECT acte, lien FROM navbar WHERE droit=2");
            $data = $req->fetchAll();
            foreach ($data as $li){
              echo '<li class="nav-item"><a class="nav-link" href='.$li['lien'].'>'.$li['acte'].'</a></li>';
            }
          }
//* Si l'utilisateur est client
          if($_SESSION['grade'] == 'client'){
            $req = $bdd->query("SELECT acte, lien FROM navbar WHERE droit=1");
            $data = $req->fetchAll();
            foreach ($data as $li){
              echo '<li class="nav-item"><a class="nav-link" href='.$li['lien'].'>'.$li['acte'].'</a></li>';
            }
          }
        }

        if(empty($_SESSION['grade'])){
    //* affichage de la page acheter des credit si non-connecter, la page est dans la bdd avec droit=1 (client)
          echo '<li class="nav-item"><a class="nav-link" href="acheter-des-credits.php">Tarif</a></li>';
        }
?> 
        <li class="nav-item"><a class="nav-link" href="nous-contacter.php">Nous contacter</a></li>
      </ul>
      <ul class="navbar-nav">
      <li class="nav-item d-none" id="nav-panier">
        <a role="button" class="nav-link text-decoration-none" onclick="tooglePanier();">
          <div id="nombre-produit" class="numberCircle"></div>
          Pannier
        </a>
      </li>
<?php
    //* deconnection || connection et inscription
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