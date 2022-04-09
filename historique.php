<?php
session_start();
if(empty($_SESSION['grade'])){
    header('location:index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    if ($_SESSION['grade'] == 'client') {
        echo '<title>Mes achats</title>';
    }
    if ($_SESSION['grade'] == 'photographe') {
        echo '<title>Mes ventes</title>';
    }
    if ($_SESSION['grade'] == 'admin') {
        echo '<title>Historique Achat/Vente</title>';
    }
    ?>
	<?php include "includes/head.php"; ?>
</head>
	<body>
		<?php 
		include "includes/bdd.php";
		include "includes/nav.php";
        
        function date_fr($date) {
            $date_fr = date("d-m-Y", strtotime($date));
            return $date_fr;
        }

        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
		?>
        <?php 
        if ($_SESSION['grade'] == 'client') { 
        ?>

            <div class="container mt-4">
                <h1 class="text-center mt-4">Mes achats</h1>
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>Aperçu</th>
                            <th>Nom de l'image</th>
                            <th>Date</th>
                            <th>Pseudo du vendeur</th>
                            <th>Prix (Crédits)</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $req = $bdd->prepare("SELECT * FROM image WHERE id_acheteur IS NOT NULL");
                        $req->execute();
                        $count = $req->rowCount();
                        
                        $nb_par_page = 10;
                        $nb_page = ceil($count/$nb_par_page);
                        $debut = ($page-1)*$nb_par_page;
                                                                        
                        $req = $bdd->prepare("SELECT * FROM image WHERE id_acheteur = :id ORDER BY date_achat DESC, heure_achat DESC, id_image DESC LIMIT $debut, $nb_par_page");
                        $req->bindValue(':id', $_SESSION['id']);
                        $req->execute();
                        $data = $req->fetchAll();
                        foreach ($data as $li) {
                            echo '<tr>';
                            echo '    <td><a href="'.$li['chemin_image'].'"><div style="background-size: cover; width: 3em; height: 3em; background-image:url('.$li['chemin_image'].')"></div></a></td>';
                            echo '    <td>'.$li['nom_image'].'</td>';
                            echo '    <td>'.$li['heure_achat'].' - '.date_fr($li['date_achat']).'</td>';
                            $req2 = $bdd->prepare("SELECT pseudo FROM user WHERE id = :id");
                            $req2->bindValue(':id', $li['id_vendeur']);
                            $req2->execute();
                            $data2 = $req2->fetch(\PDO::FETCH_OBJ);
                            $pseudoVendeur = $data2->pseudo;
                            echo '    <td><a class="text-decoration-none text-light hover-color-histo-link" href="profil.php?id='.$li['id_vendeur'].'">'.$pseudoVendeur.'</a></td>';
                            echo '    <td>'.$li['prix_image'].'</td>';
                            echo '    <td><a class="text-decoration-none text-light hover-color-histo-link" href="'.$li['chemin_image'].'" download="'.$li['nom_image'].'">telecharger l\'image</td>';
                            echo '</tr>';
                        }
        } 
        if ($_SESSION['grade'] == 'photographe') { 
        ?>

            <div class="container mt-4">
                <h1 class="text-center mt-4">Mes ventes</h1>
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>Aperçu</th>
                            <th>Nom de l'image</th>
                            <th>Date</th>
                            <th>Pseudo de l'acheteur</th>
                            <th>Prix (Crédits)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $req = $bdd->prepare("SELECT * FROM image WHERE id_acheteur IS NOT NULL");
                        $req->execute();
                        $count = $req->rowCount();
                        
                        $nb_par_page = 10;
                        $nb_page = ceil($count/$nb_par_page);
                        $debut = ($page-1)*$nb_par_page;
                        
                        $req = $bdd->prepare("SELECT * FROM image WHERE id_vendeur = :id AND id_acheteur IS NOT NULL ORDER BY date_achat DESC, heure_achat DESC, id_image DESC LIMIT $debut, $nb_par_page");
                        $req->bindValue(':id', $_SESSION['id']);
                        $req->execute();
                        $data = $req->fetchAll();
                        foreach ($data as $li) {
                            echo '<tr>';
                            echo '    <td><a href="'.$li['chemin_image'].'"><div style="background-size: cover; width: 3em; height: 3em; background-image:url('.$li['chemin_image'].')"></div></a></td>';
                            echo '    <td>'.$li['nom_image'].'</td>';
                            echo '    <td>'.$li['heure_achat'].' - '.date_fr($li['date_achat']).'</td>';
                            $req2 = $bdd->prepare("SELECT pseudo FROM user WHERE id = :id");
                            $req2->bindValue(':id', $li['id_acheteur']);
                            $req2->execute();
                            $data2 = $req2->fetch(\PDO::FETCH_OBJ);
                            $pseudoAcheteur = $data2->pseudo;
                            echo '    <td><a class="text-decoration-none text-light hover-color-histo-link" href="profil.php?id='.$li['id_acheteur'].'">'.$pseudoAcheteur.'</a></td>';
                            echo '    <td>'.$li['prix_image'].'</td>';
                            echo '</tr>';
                        }
        } 
        if ($_SESSION['grade'] == 'admin') { 
            ?>

            <div class="container mt-4">
                <h1 class="text-center mt-4">Historique Achat/Vente</h1>
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>Aperçu</th>
                            <th>Nom de l'image</th>
                            <th>Date</th>
                            <th>Pseudo de l'acheteur</th>
                            <th>Pseudo du vendeur</th>
                            <th>Prix (Crédits)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $req = $bdd->prepare("SELECT * FROM image WHERE id_acheteur IS NOT NULL");
                        $req->execute();
                        $count = $req->rowCount();
                        
                        $nb_par_page = 10;
                        $nb_page = ceil($count/$nb_par_page);
                        $debut = ($page-1)*$nb_par_page;
                        $req = $bdd->prepare("SELECT * FROM image WHERE id_acheteur IS NOT NULL ORDER BY date_achat DESC, heure_achat DESC, id_image DESC LIMIT $debut, $nb_par_page");
                        $req->execute();
                        $data = $req->fetchAll();
                        foreach ($data as $li) {
                            $req2 = $bdd->prepare("SELECT pseudo FROM user WHERE id = :id");
                            $req2->bindValue(':id', $li['id_acheteur']);
                            $req2->execute();
                            $data2 = $req2->fetch(\PDO::FETCH_OBJ);
                            $pseudoAcheteur = $data2->pseudo;
                            $req3 = $bdd->prepare("SELECT pseudo FROM user WHERE id = :id");
                            $req3->bindValue(':id', $li['id_vendeur']);
                            $req3->execute();
                            $data3 = $req3->fetch(\PDO::FETCH_OBJ);
                            $pseudoVendeur = $data3->pseudo;
                            echo '<tr>';
                            echo '    <td><a href="'.$li['chemin_image'].'"><div style="background-size: cover; width: 3em; height: 3em; background-image:url('.$li['chemin_image'].')"></div></a></td>';
                            echo '    <td>'.$li['nom_image'].'</td>';
                            echo '    <td>'.$li['heure_achat'].' - '.date_fr($li['date_achat']).'</td>';
                            echo '    <td><a class="text-decoration-none text-light hover-color-histo-link" href="profil.php?id='.$li['id_acheteur'].'">'.$pseudoAcheteur.'</a></td>';
                            echo '    <td><a class="text-decoration-none text-light hover-color-histo-link" href="profil.php?id='.$li['id_vendeur'].'">'.$pseudoVendeur.'</a></td>';
                            echo '    <td>'.$li['prix_image'].'</td>';
                            echo '</tr>';
                        }
        } 
        ?>
                    </tbody>
                </table>
                <ul class="pagination">
                    <?php 
                    if ($nb_page < 5) {
                        for ($i=1; $i<=$nb_page; $i++) {
                            echo "<li class='page-item'><a class='page-link' href='historique.php?page=$i'>$i</a></li>";
                        }
                    } else {
                        echo "<li class='page-item'><a class='page-link' href='historique.php?page=1'>1</a></li>";
                        if ($page <= 2) {
                            echo "<li class='page-item'><a class='page-link' href='historique.php?page=2'>2</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='historique.php?page=3'>3</a></li>";
                            echo "<li class='page-item disabled'><a class='page-link'>...</a></li>";
                        } elseif ($page == 3) {
                            echo "<li class='page-item'><a class='page-link' href='historique.php?page=2'>2</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='historique.php?page=3'>3</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='historique.php?page=4'>4</a></li>";
                            echo "<li class='page-item disabled'><a class='page-link'>...</a></li>";
                        } elseif ($page == ($nb_page-2)) {
                            echo "<li class='page-item disabled'><a class='page-link'>...</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='historique.php?page=".($nb_page-3)."'>".($nb_page-3)."</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='historique.php?page=".($nb_page-2)."'>".($nb_page-2)."</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='historique.php?page=".($nb_page-1)."'>".($nb_page-1)."</a></li>";
                        } elseif ($page > ($nb_page-2)) {
                            echo "<li class='page-item disabled'><a class='page-link'>...</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='historique.php?page=".($nb_page-2)."'>".($nb_page-2)."</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='historique.php?page=".($nb_page-1)."'>".($nb_page-1)."</a></li>";
                        } else {
                            echo "<li class='page-item disabled'><a class='page-link'>...</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='historique.php?page=".($page-1)."'>".($page-1)."</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='historique.php?page=$page'>$page</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='historique.php?page=".($page+1)."'>".($page+1)."</a></li>";
                            echo "<li class='page-item disabled'><a class='page-link'>...</a></li>";
                        }
                        echo "<li class='page-item'><a class='page-link' href='historique.php?page=$nb_page'>$nb_page</a></li>";
                    }
                    ?>
                </ul>
            </div>

        <!-- Script pour la pagination -->
        <script>
            $(function(){
                let url = window.location;
                let params = new URLSearchParams(url.search);
                let page = params.get('page');
                let numPage = document.getElementsByClassName('page-item');

                for (i = 0; i < numPage.length; i++){
                    if ( numPage[i].firstChild.innerHTML == page) {
                        numPage[i].className = "page-item active";
                    }
                }
            });
        </script>
		<?php include "includes/footer.php"; ?>
	</body>
</html>