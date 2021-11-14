<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Acheter des crédits</title>
	<?php include "includes/head.php"; ?>
</head>
	<body>
		<?php 
		include "includes/bdd.php";
		include "includes/nav.php";

		// ! Définir l'affichage en fonction de l'utilisateur (connecter ou non)
		// ! Tarif pour les non-connecter
		// ! Achetez des crédit pour les client et admin
		?>
		

		<?php include "includes/footer.php"; ?>
	</body>
</html>