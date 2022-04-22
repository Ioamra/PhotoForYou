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
		
		// ! Définir l'affichage en fonction de l'utilisateur (connecter ou non)
		// ! Tarif pour les non-connecter
		// ! Achetez des crédit pour les client et admin
		
		if (isset($_POST['submit'])) {
			$req = $bdd->prepare("SELECT credits FROM user WHERE id = :id");
			$req->bindValue(':id', $_SESSION['id']);
			$req->execute();
			$data = $req->fetch(\PDO::FETCH_OBJ);
			$credits = $data->credits;
			
			//* Echange EUR to CR
			if (isset($_POST['num-carte'])) {
				$newQteCR = $credits + ($_POST['input-switch-money-1'] * 50);
				$req = $bdd->prepare("UPDATE user SET credits = :CR WHERE id = :id");
				$req->bindValue(':CR', $newQteCR);
				$req->bindValue(':id', $_SESSION['id']);
				$req->execute();
			}

			//* Echange CR to EUR
			if (isset($_POST['rib'])) {
				$newQteCR = $credits - $_POST['input-switch-money-1'];
				$req = $bdd->prepare("UPDATE user SET credits = :CR WHERE id = :id");
				$req->bindValue(':CR', $newQteCR);
				$req->bindValue(':id', $_SESSION['id']);
				$req->execute();
			}
		}
		include "includes/nav.php";
		include "includes/panier.php"; 
		?>
		<?php 
		if (empty($_SESSION['grade'])) {
		?>

		<div class="row justify-content-center mt-4" style="width:100%;">
			<div class="col-4 text-center mt-4">
				<h1>Tarif</h1>
				<hr><br><br>
				<h3>1 EUR = 50 Credits</h3>
				<br><br><br><br>
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
				<br><br><br>
				<a href="connexion.php">Pour acheter des crédits veuillez vous connecter.</a>
			</div>
		</div>

		<?php
		} else {
			?>

		<div class="row justify-content-center mt-4" style="width:100%;">
			<div class="col-4 text-center mt-4">
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

					
					<div id="form-achat">
						<div class="mb-3">
							<label for="nom-carte" class="form-label">Nom du détenteur de la carte</label>
							<input type="text" class="form-control" name="nom-carte">
						</div>
						<div class="mb-3">
							<label for="num-carte" class="form-label">Numéros de la carte</label>
							<input type="int" class="form-control" name="num-carte">
						</div>
						<div class="mb-3">
							<label for="date-carte" class="form-label">Date d'expiration</label>
							<input type="text" class="form-control" name="date-carte">
						</div>
						<div class="mb-3">
							<label for="num-secu-carte" class="form-label">Code de sécurité</label>
							<input type="int" class="form-control" name="num-secu-carte">
						</div>
					</div>
					<button type="submit" name="submit" class="btn btn-primary" onclick="confirm('Etes vous sur de vouloir valider.')">Validé l'achat</button>
					<br><br>
					<img class="w-100" src="assets/img/liste-payement.jpg">
        		</form>
			</div>
		</div>
<?php 
		}
?>
		<?php include "includes/footer.php"; ?>
	</body>
</html>