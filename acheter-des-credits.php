<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Acheter des crédits</title>
	<?php include "includes/head.php"; ?>
	<script src="assets/js/acheter-des-credits.js"></script>
</head>
	<body>
		<?php 
		include "includes/bdd.php";
		include "includes/nav.php";
		include "includes/panier.php"; 

		// ! Définir l'affichage en fonction de l'utilisateur (connecter ou non)
		// ! Tarif pour les non-connecter
		// ! Achetez des crédit pour les client et admin

		if (isset($_POST['submit'])) {
			$req = $bdd->prepare("SELECT credits FROM user WHERE id = :id");
			$req->bindValue(":id", $_SESSION['id']);
			$data = $req->fetchAll();
			var_dump($data);
		}
		?>
		<div class="row justify-content-center mt-4" style="width:100%;">
			<div class="col-4 text-center">
				<form method="post">
					<h1 id="titre-boutique">Acheter des crédits</h1><br>
	
					<div class="row">
						<div class="col">
							<input type="text" id="input-switch-money-1" name="input-switch-money-1"><span id="span-switch-money-1">EUR</span>
						</div>
						<div class="col">
							<a id="btn-switch-money" class="btn btn-outline-secondary">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
									<path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zm14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5z"/>
								</svg>
							</a>
						</div>
						<div class="col">
							<input type="text" id="input-switch-money-2" name="input-switch-money-2" disabled><span id="span-switch-money-2">Crédits</span>
						</div>
					</div>

					
					<div class="">
						<div class="mb-3">
							<label for="nom-carte" class="form-label">Nom du détenteur de la carte</label>
							<input type="text" class="form-control" name="nom-carte" pattern="[a-zA-Zéè]{3,15}" required>
						</div>
						<div class="mb-3">
							<label for="num-carte" class="form-label">Numéros de la carte</label>
							<input type="int" class="form-control" name="num-carte" pattern="[0-9]{16}" required>
						</div>
						<div class="mb-3">
							<label for="date-carte" class="form-label">Date d'expiration</label>
							<input type="text" class="form-control" name="date-carte" pattern="[0-9/]{5}" required>
						</div>
						<div class="mb-3">
							<label for="num-secu-carte" class="form-label">Code de sécurité</label>
							<input type="int" class="form-control" name="num-secu-carte" pattern="[0-9]{3}" required>
						</div>
						<button type="submit" name="submit" class="btn btn-primary">Validé l'achat</button>
					</div><br><br>
					<img class="w-100" src="assets/img/liste-payement.jpg">
        		</form>
			</div>
		</div>

		<?php include "includes/footer.php"; ?>
	</body>
</html>